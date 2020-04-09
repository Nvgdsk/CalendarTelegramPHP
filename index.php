
$date = date('Y-m-d');
$month = date('F');
$monthD = date("m");
$day = date('t');
$day_today = date('d');
$year = date('Y');
    
function calendar($year, $day, $day_today, $month, $monthD, $countm, $real_date)
{

    $inline_button1 = array("text" => "<", "callback_data" => 'prevM:' . ($countm - 1));//кнопка влево
    $inline_button2 = array("text" => ">", "callback_data" => 'nextM:' . ($countm + 1));//кнопка вправо
    $inline_button4 = array("text" => $month . " " . $year, "callback_data" => ' ');//кнопка с месяцом и годом
    $date = $year . "-" . $monthD . "-01";
    $week = date("w", strtotime($date));


    for ($i = 0; $i < 7; $i++) {
        if ($i == 0) {
            $z = 'Пн';
        } elseif ($i == 1) {
            $z = 'Вт';
        } elseif ($i == 2) {
            $z = 'Ср';
        } elseif ($i == 3) {
            $z = 'Чт';
        } elseif ($i == 4) {
            $z = 'Пт';
        } elseif ($i == 5) {
            $z = 'Сб';
        } elseif ($i == 6) {
            $z = 'Нд';
        }


        $dayofmonth[] = array("text" => $z, "callback_data" => ' ');
    }

    if ($week == 0) {
        $week = 7;
    }
    $as = [];
    for ($i = 0; $i < $week - 1; $i++) {
        $as[] = array("text" => ' ', "callback_data" => ' ');
    }

    $inline_keyboard = [[$inline_button1, $inline_button4, $inline_button2], $dayofmonth];//шапка календаря
    for ($i = 0; $i < 42; $i++) {

        $date = $year . "-" . $monthD . "-" . ($i + 1);

        if ($i < $day) {

            if ((count($as) + 0) % 7 == 0) {

                $inline_keyboard[] = $as;
                unset($as);
            }


            if (strtotime($real_date) > strtotime($date)) {
                $as[] = array("text" => ' ', "callback_data" => ' ');
            } else {
                if ($i + 1 == $day_today) {
                    $as[] = array("text" => "*" . ($i + 1) . "*", "callback_data" => $year . "-" . $monthD . "-" . ($i + 1) . " 23:59:59");
                } else {
                    $as[] = array("text" => $i + 1, "callback_data" => $year . "-" . $monthD . "-" . ($i + 1) . " 23:59:59");
                }
            }


        } else {
            if ((count($as) + 0) % 7 == 0) {

                $inline_keyboard[] = $as;
                unset($as);
            }
            $as[] = array("text" => ' ', "callback_data" => ' ');
        }

    }


    $keyboard = array("inline_keyboard" => $inline_keyboard);
    $replyMarkup = json_encode($keyboard);
    return $replyMarkup;
}

$bot->sendmessage($msgchatid, 'Calendar' . '&parse_mode=Markdown&reply_markup=' . calendar($year, $day, $day_today, $month, $monthD, 0, $date));
