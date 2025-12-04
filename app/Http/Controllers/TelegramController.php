<?php

namespace App\Http\Controllers;

use App\Models\TelegramModel;
use Illuminate\Support\Facades\DB;
use Exception;

date_default_timezone_set('Asia/Makassar');

class TelegramController extends Controller
{
    public static function webhookOtomateBot()
    {
        try
        {
            $tokenBot = env('TELEGRAM_BOT_TOKEN') ?? '7584436866:AAELFhZd8Eh6gWFHQCFqm24FKOGyYHf4OBY';

            if (!$tokenBot)
            {
                return response()->json(['error' => 'Bot token not configured'], 500);
            }

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL            => "https://api.telegram.org/bot{$tokenBot}/getWebhookInfo",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_CUSTOMREQUEST  => 'GET',
                CURLOPT_TIMEOUT        => 30,
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $curlError = curl_error($curl);
            curl_close($curl);

            if ($curlError)
            {
                return response()->json(['error' => 'Failed to connect to Telegram API'], 500);
            }

            if ($httpCode !== 200)
            {
                return response()->json(['error' => 'Telegram API returned error'], 500);
            }

            print_r($response);

            $result = json_decode($response);

            if ($result && isset($result->result->pending_update_count) && $result->result->pending_update_count != 0)
            {
                $url = 'https://otomate.telkomakses-borneo.id';

                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL            => "https://api.telegram.org/bot{$tokenBot}/setWebhook?url={$url}/api/telegram/otomateBot&max_connections=100&drop_pending_updates=true",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_CUSTOMREQUEST  => 'POST',
                    CURLOPT_TIMEOUT        => 30,
                ]);

                $response = curl_exec($curl);
                $curlError = curl_error($curl);
                curl_close($curl);

                if ($curlError)
                {
                    return response()->json(['error' => 'Failed to set webhook'], 500);
                }

                print_r(json_decode($response));
            }
            else
            {
                print_r("Pending Update Count is Zero \n");
            }

            return response()->json(['success' => true]);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public static function otomateBot()
    {
        try
        {
            $tokenBot = env('TELEGRAM_BOT_TOKEN') ?? '7584436866:AAELFhZd8Eh6gWFHQCFqm24FKOGyYHf4OBY';

            if (!$tokenBot)
            {
                return response()->json(['error' => 'Bot token not configured'], 500);
            }

            $input = file_get_contents('php://input');
            if (!$input)
            {
                return response()->json(['error' => 'No data received'], 400);
            }

            $update = json_decode($input, true);
            if (!$update)
            {
                return response()->json(['error' => 'Invalid JSON'], 400);
            }

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['text' => 'Start', 'callback_data' => '/start']
                    ],
                    [
                        ['text' => 'ID Site', 'callback_data' => '/id_site'],
                        ['text' => 'ID Ring', 'callback_data' => '/id_ring']
                    ],
                ],
            ];

            if (isset($update['callback_query']))
            {
                return self::handleCallbackQuery($update['callback_query'], $tokenBot, $keyboard);
            }

            if (isset($update['message']))
            {
                return self::handleMessage($update['message'], $tokenBot, $keyboard);
            }

            return response()->json(['error' => 'Unknown update type'], 400);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    private static function handleCallbackQuery($callback, $tokenBot, $keyboard)
    {
        try
        {
            $chat_type = $callback['message']['chat']['type'] ?? '';
            $chat_id = $callback['message']['chat']['id'];
            $messageID = $callback['message']['message_id'];
            $data = $callback['data'];
            $chat_title = self::getChatTitle($callback['message']['chat'] ?? []);
            $thread_id = $callback['message']['message_thread_id'] ?? null;

            TelegramModel::answerCallbackQuery($tokenBot, $callback['id']);

            if ($data === '/id_site')
            {
                self::setUserState($chat_id, ['step' => 'input_id_site', 'thread_id' => $thread_id, 'message_id' => $messageID]);

                if ($thread_id)
                {
                    TelegramModel::sendMessageReplyThread($tokenBot, $chat_id, $thread_id, '🔖 Silakan masukkan Site NE', $messageID);
                }
                else
                {
                    TelegramModel::sendMessageReply($tokenBot, $chat_id, '🔖 Silakan masukkan Site NE', $messageID);
                }
                return response()->json(['success' => true]);
            }

            if ($data === '/id_ring')
            {
                self::setUserState($chat_id, ['step' => 'input_id_ring', 'thread_id' => $thread_id, 'message_id' => $messageID]);

                if ($thread_id)
                {
                    TelegramModel::sendMessageReplyThread($tokenBot, $chat_id, $thread_id, '🔖 Silakan masukkan Ring ID', $messageID);
                }
                else
                {
                    TelegramModel::sendMessageReply($tokenBot, $chat_id, '🔖 Silakan masukkan Ring ID', $messageID);
                }
                return response()->json(['success' => true]);
            }

            if (strpos($data, 'site_ne_') === 0)
            {
                $siteNe = substr($data, 8);
                $response = self::searchSiteByName($siteNe);
                self::sendResponse($tokenBot, $chat_id, $thread_id, $messageID, $response, $keyboard);
                return response()->json(['success' => true]);
            }

            $message = self::processCommand($data, $callback['message']['chat'], $callback['message']);

            self::sendResponse($tokenBot, $chat_id, $thread_id, $messageID, $message, $keyboard);
            return response()->json(['success' => true]);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    private static function handleMessage($message, $tokenBot, $keyboard)
    {
        try
        {
            $chat_type = $message['chat']['type'] ?? '';
            $chat_id = $message['chat']['id'];
            $messageID = $message['message_id'];
            $text = $message['text'] ?? '';
            $thread_id = $message['message_thread_id'] ?? null;

            $state = self::getUserState($chat_id);

            if ($state && $state['step'] === 'input_id_site' && !empty($text))
            {
                $state_thread_id = $state['thread_id'] ?? null;
                $response = self::searchSiteByName($text);
                self::clearUserState($chat_id);
                self::sendResponse($tokenBot, $chat_id, $state_thread_id, $messageID, $response, $keyboard);
                return response()->json(['success' => true]);
            }

            if ($state && $state['step'] === 'input_id_ring' && !empty($text))
            {
                $state_thread_id = $state['thread_id'] ?? null;
                $response = self::searchSiteByRing($text, $tokenBot, $chat_id);
                self::clearUserState($chat_id);

                if (is_array($response) && isset($response['keyboard']))
                {
                    if ($state_thread_id)
                    {
                        TelegramModel::sendMessageThreadWithMarkup($tokenBot, $chat_id, $state_thread_id, $response['message'], $response['keyboard'], $messageID);
                    }
                    else
                    {
                        TelegramModel::sendMessageReplyMarkupButton($tokenBot, $chat_id, $response['message'], $response['keyboard'], $messageID);
                    }
                }
                else
                {
                    self::sendResponse($tokenBot, $chat_id, $state_thread_id, $messageID, $response, $keyboard);
                }
                return response()->json(['success' => true]);
            }

            if (!empty($text) && substr($text, 0, 1) == '/')
            {
                if (strpos($text, '/id_site') === 0)
                {
                    $parts = explode(' ', $text, 2);
                    if (isset($parts[1]) && !empty(trim($parts[1])))
                    {
                        $siteNe = trim($parts[1]);
                        $response = self::searchSiteByName($siteNe);
                        self::sendResponse($tokenBot, $chat_id, $thread_id, $messageID, $response, $keyboard);
                    }
                    else
                    {
                        self::setUserState($chat_id, ['step' => 'input_id_site', 'thread_id' => $thread_id, 'message_id' => $messageID]);

                        if ($thread_id)
                        {
                            TelegramModel::sendMessageReplyThread($tokenBot, $chat_id, $thread_id, '🔖 Silakan masukkan Site NE', $messageID);
                        }
                        else
                        {
                            TelegramModel::sendMessageReply($tokenBot, $chat_id, '🔖 Silakan masukkan Site NE', $messageID);
                        }
                    }
                    return response()->json(['success' => true]);
                }

                if (strpos($text, '/id_ring') === 0)
                {
                    $parts = explode(' ', $text, 2);
                    if (isset($parts[1]) && !empty(trim($parts[1])))
                    {
                        $ringId = trim($parts[1]);
                        $response = self::searchSiteByRing($ringId, $tokenBot, $chat_id);

                        if (is_array($response) && isset($response['keyboard']))
                        {
                            if ($thread_id)
                            {
                                TelegramModel::sendMessageThreadWithMarkup($tokenBot, $chat_id, $thread_id, $response['message'], $response['keyboard'], $messageID);
                            }
                            else
                            {
                                TelegramModel::sendMessageReplyMarkupButton($tokenBot, $chat_id, $response['message'], $response['keyboard'], $messageID);
                            }
                        }
                        else
                        {
                            self::sendResponse($tokenBot, $chat_id, $thread_id, $messageID, $response, $keyboard);
                        }
                    }
                    else
                    {
                        self::setUserState($chat_id, ['step' => 'input_id_ring', 'thread_id' => $thread_id, 'message_id' => $messageID]);

                        if ($thread_id)
                        {
                            TelegramModel::sendMessageReplyThread($tokenBot, $chat_id, $thread_id, '🔖 Silakan masukkan Ring ID', $messageID);
                        }
                        else
                        {
                            TelegramModel::sendMessageReply($tokenBot, $chat_id, '🔖 Silakan masukkan Ring ID', $messageID);
                        }
                    }
                    return response()->json(['success' => true]);
                }

                $response = self::processCommand($text, $message['chat'], $message);
                self::sendResponse($tokenBot, $chat_id, $thread_id, $messageID, $response, $keyboard);
            }

            return response()->json(['success' => true]);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    private static function processCommand($command, $chat, $message)
    {
        $chat_title = self::getChatTitle($chat);

        if (strpos($command, '/start') === 0)
        {
            return self::getGreetingMessage($chat_title);
        }

        return 'Maaf, perintah tidak tersedia.';
    }

    private static function getGreetingMessage($chat_title)
    {
        $hour = date('H', time());

        if ($hour >= 4 && $hour < 11)
        {
            $saying = 'Selamat Pagi';
        }
        elseif ($hour >= 11 && $hour < 15)
        {
            $saying = 'Selamat Siang';
        }
        elseif ($hour >= 15 && $hour < 18)
        {
            $saying = 'Selamat Sore';
        }
        else
        {
            $saying = 'Selamat Malam';
        }

        return "Halo <b>$chat_title</b>, $saying! 👋";
    }

    private static function searchSiteByName($siteName)
    {
        try
        {
            $siteName = trim($siteName);
            if (empty($siteName))
            {
                return "Silakan masukkan site NE yang valid.";
            }

            $data = DB::table('tb_source_diginav_mtel')
                ->where('site_ne', 'LIKE', "%$siteName%")
                ->first();

            if (!$data)
            {
                return "Site NE <b>$siteName</b> tidak ditemukan.";
            }

            $message  = "📋 <b>Informasi Site</b>\n\n";
            $message .= "<code>";
            $message .= "Ring ID       : " . ($data->ring_id ?? 'NULL') . "\n";
            $message .= "Site NE       : " . ($data->site_ne ?? 'NULL') . "\n";
            $message .= "Site Name NE  : " . ($data->site_name_ne ?? 'NULL') . "\n";
            $message .= "Site FE       : " . ($data->site_fe ?? 'NULL') . "\n";
            $message .= "Site Name FE  : " . ($data->site_name_fe ?? 'NULL') . "\n";
            $message .= "Panjang Kabel : " . ($data->real_kabel ?? 'NULL') . " m\n";
            $message .= "Jumlah Closure: NULL\n";
            $message .= "Maincore      : NULL\n";
            $message .= "Cek RSL       : NULL\n";
            $message .= "Jenis Link    : NULL\n";
            $message .= "</code>";

            $locations = [];

            if (
                !empty($data->site_lat_ne) && !empty($data->site_long_ne) &&
                $data->site_lat_ne !== 'NULL' && $data->site_long_ne !== 'NULL'
            )
            {
                $locations['ne'] = [
                    'latitude' => $data->site_lat_ne,
                    'longitude' => $data->site_long_ne,
                    'title' => 'Lokasi Site NE'
                ];
            }

            if (
                !empty($data->site_lat_fe) && !empty($data->site_long_fe) &&
                $data->site_lat_fe !== 'NULL' && $data->site_long_fe !== 'NULL'
            )
            {
                $locations['fe'] = [
                    'latitude' => $data->site_lat_fe,
                    'longitude' => $data->site_long_fe,
                    'title' => 'Lokasi Site FE'
                ];
            }

            $result = ['message' => $message];

            if (!empty($locations))
            {
                $result['locations'] = $locations;
            }

            if (isset($locations['ne']) && isset($locations['fe']))
            {
                $lat_ne = $locations['ne']['latitude'];
                $long_ne = $locations['ne']['longitude'];
                $lat_fe = $locations['fe']['latitude'];
                $long_fe = $locations['fe']['longitude'];

                $result['inline_button'] = [
                    'inline_keyboard' => [
                        [
                            [
                                'text' => '🗺️ Rute: Site NE ke Site FE',
                                'url' => "https://www.google.com/maps/dir/{$lat_ne},{$long_ne}/{$lat_fe},{$long_fe}"
                            ]
                        ]
                    ]
                ];
            }

            return $result;
        }
        catch (Exception $e)
        {
            return "Maaf, terjadi kesalahan saat mencari data site.";
        }
    }

    private static function searchSiteByRing($ringId, $tokenBot, $chatId)
    {
        try
        {
            $ringId = trim($ringId);
            if (empty($ringId))
            {
                return "Silakan masukkan Ring ID yang valid.";
            }

            $sites = DB::table('tb_source_diginav_mtel')
                ->where('ring_id', 'LIKE', "%$ringId%")
                ->select('site_ne', 'site_name_ne', 'site_fe', 'site_name_fe')
                ->distinct()
                ->get();

            if ($sites->isEmpty())
            {
                return "Ring ID <b>$ringId</b> tidak ditemukan.";
            }

            $buttons = [];
            $count = 0;

            foreach ($sites as $site)
            {
                if (!empty($site->site_ne))
                {
                    $buttonText = $site->site_ne . ' ' . ($site->site_name_ne ?? '') . ' <> ' . ($site->site_fe ?? '') . ' ' . ($site->site_name_fe ?? '');
                    $buttonText = trim($buttonText);

                    $buttons[] = [
                        [
                            'text' => $buttonText,
                            'callback_data' => 'site_ne_' . $site->site_ne
                        ]
                    ];
                    $count++;
                }
            }

            $keyboard = [
                'inline_keyboard' => $buttons
            ];

            return [
                'message' => "🔍 Ditemukan <b>" . count($sites) . "</b> site untuk Ring ID <b>$ringId</b>\n\nSilakan Pilih Site :",
                'keyboard' => $keyboard
            ];
        }
        catch (Exception $e)
        {
            return "Maaf, terjadi kesalahan saat mencari data ring.";
        }
    }

    private static function sendResponse($tokenBot, $chat_id, $thread_id, $messageID, $message, $keyboard)
    {
        try
        {
            if (is_array($message))
            {
                if (isset($message['message']))
                {
                    if (isset($message['inline_button']))
                    {
                        if ($thread_id)
                        {
                            TelegramModel::sendMessageThreadWithMarkup($tokenBot, $chat_id, $thread_id, $message['message'], $message['inline_button']);
                        }
                        else
                        {
                            TelegramModel::sendMessageReplyMarkupButton($tokenBot, $chat_id, $message['message'], $message['inline_button'], $messageID);
                        }
                    }
                    else
                    {
                        if ($thread_id)
                        {
                            TelegramModel::sendMessageReplyThread($tokenBot, $chat_id, $thread_id, $message['message'], $messageID);
                        }
                        else
                        {
                            TelegramModel::sendMessageReply($tokenBot, $chat_id, $message['message'], $messageID);
                        }
                    }
                    usleep(100000);

                    if (isset($message['locations']))
                    {
                        foreach ($message['locations'] as $location)
                        {
                            $locationTitle = $location['title'] ?? 'Lokasi';
                            if ($thread_id)
                            {
                                TelegramModel::sendMessageReplyThread($tokenBot, $chat_id, $thread_id, "📍 <b>{$locationTitle}</b>", $messageID);
                            }
                            else
                            {
                                TelegramModel::sendMessageReply($tokenBot, $chat_id, "📍 <b>{$locationTitle}</b>", $messageID);
                            }
                            usleep(100000);

                            if ($thread_id)
                            {
                                TelegramModel::sendLocationThread($tokenBot, $chat_id, $thread_id, $location['latitude'], $location['longitude']);
                            }
                            else
                            {
                                TelegramModel::sendLocation($tokenBot, $chat_id, $location['latitude'], $location['longitude']);
                            }
                            usleep(100000);
                        }
                    }

                    if ($thread_id)
                    {
                        TelegramModel::sendMessageThreadWithMarkup($tokenBot, $chat_id, $thread_id, "Pilih Menu :", $keyboard, $messageID);
                    }
                    else
                    {
                        TelegramModel::sendMessageReplyMarkupButton($tokenBot, $chat_id, "Pilih Menu :", $keyboard, $messageID);
                    }
                }
                else
                {
                    foreach ($message as $index => $msg)
                    {
                        if ($index === 'location')
                        {
                            continue;
                        }

                        if ($thread_id)
                        {
                            TelegramModel::sendMessageReplyThread($tokenBot, $chat_id, $thread_id, $msg, $messageID);
                        }
                        else
                        {
                            TelegramModel::sendMessageReply($tokenBot, $chat_id, $msg, $messageID);
                        }
                        usleep(100000);
                    }

                    if (isset($message['location']))
                    {
                        $latitude = $message['location']['latitude'];
                        $longitude = $message['location']['longitude'];

                        if ($thread_id)
                        {
                            TelegramModel::sendLocationThread($tokenBot, $chat_id, $thread_id, $latitude, $longitude);
                        }
                        else
                        {
                            TelegramModel::sendLocation($tokenBot, $chat_id, $latitude, $longitude);
                        }
                        usleep(100000);
                    }

                    if ($thread_id)
                    {
                        TelegramModel::sendMessageThreadWithMarkup($tokenBot, $chat_id, $thread_id, "Pilih Menu :", $keyboard, $messageID);
                    }
                    else
                    {
                        TelegramModel::sendMessageReplyMarkupButton($tokenBot, $chat_id, "Pilih Menu :", $keyboard, $messageID);
                    }
                }
            }
            else
            {
                if ($thread_id)
                {
                    TelegramModel::sendMessageReplyThread($tokenBot, $chat_id, $thread_id, $message, $messageID);
                    usleep(100000);
                    TelegramModel::sendMessageThreadWithMarkup($tokenBot, $chat_id, $thread_id, "Pilih Menu :", $keyboard, $messageID);
                }
                else
                {
                    TelegramModel::sendMessageReply($tokenBot, $chat_id, $message, $messageID);
                    usleep(100000);
                    TelegramModel::sendMessageReplyMarkupButton($tokenBot, $chat_id, "Pilih Menu :", $keyboard, $messageID);
                }
            }
        }
        catch (Exception $e)
        {
        }
    }

    private static function getUserState($chat_id)
    {
        $file = storage_path("app/user_state_$chat_id.json");
        try
        {
            if (file_exists($file))
            {
                $content = file_get_contents($file);
                if ($content === false)
                {
                    return null;
                }
                return json_decode($content, true);
            }
        }
        catch (Exception $e)
        {
        }

        return null;
    }

    private static function setUserState($chat_id, $data)
    {
        $file = storage_path("app/user_state_$chat_id.json");
        try
        {
            $directory = dirname($file);
            if (!is_dir($directory))
            {
                mkdir($directory, 0755, true);
            }

            file_put_contents($file, json_encode($data));
        }
        catch (Exception $e)
        {
        }
    }

    private static function clearUserState($chat_id)
    {
        $file = storage_path("app/user_state_$chat_id.json");
        try
        {
            if (file_exists($file))
            {
                unlink($file);
            }
        }
        catch (Exception $e)
        {
        }
    }

    private static function getChatTitle($chat)
    {
        if (empty($chat))
        {
            return 'Unknown';
        }

        if (isset($chat['title']) && !empty($chat['title']))
        {
            return htmlspecialchars($chat['title'], ENT_QUOTES, 'UTF-8');
        }

        $name = '';
        if (isset($chat['first_name']) && !empty($chat['first_name']))
        {
            $name = $chat['first_name'];
        }

        if (isset($chat['last_name']) && !empty($chat['last_name']))
        {
            $name .= ' ' . $chat['last_name'];
        }

        return !empty($name) ? htmlspecialchars(trim($name), ENT_QUOTES, 'UTF-8') : 'Unknown';
    }
}
