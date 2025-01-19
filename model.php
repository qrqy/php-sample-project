<?php

/**
 * Return list of users.
 */
function get_users($conn)
{
    //Выполняем запрос чтобы получить пользователей у которых были транзакции (подключаем таблицу кошельков, по кошелькам подключаем таблицу переводов, INNER JOID чтобы убрать пустых юзеров) 
    $statement = $conn->query('SELECT users.name, users.id  FROM `users` INNER JOIN `user_accounts` ON users.id = user_accounts.user_id INNER JOIN `transactions` ON user_accounts.id = transactions.account_from OR user_accounts.id = transactions.account_to GROUP BY users.id, users.name');
    //Создаем массив и заполняем
    $users = array();
    //Цикл по результату запроса
    while ($row = $statement->fetch()) {
        $users[$row['id']] = $row['name'];
    }
    return $users;
}

/**
 * Return user.
 */
function get_user($user_id, $conn)
{
    //Выполняем запрос к таблице пользовтелей и получаем имя юзера по айдишнику 
    $statement = $conn->query('SELECT users.name, users.id  FROM `users` WHERE users.id='.$user_id);
    //Создаем массив и заполняем
    $user = "";
    //Цикл по результату запроса
    if ($row = $statement->fetch()) {
        $user = $row['name'];
    }
    return $user;
}

/**
 * Return transactions balances of given user.
 */
function get_user_transactions_balances($user_id, $conn)
{     
    //Получаем кошельки пользователей
    $statement = $conn->query('SELECT user_accounts.id as `payment`  FROM `users` LEFT JOIN `user_accounts` ON users.id=user_accounts.user_id WHERE users.id='.$user_id);
    $payments = array();
    while ($row = $statement->fetch()) {
        $payments[] = $row['payment'];
    }
    $payments_value = [];
    //В цикле проходимся по кошелькам
    foreach ($payments as $key => $value) {
        //Получаем транзакции этого кошелька
        $statement = $conn->query('SELECT * FROM `transactions` WHERE account_to = '.$value.' OR account_from = '.$value.' ORDER BY trdate');
        //Проходимся по транзакциям
        while ($row = $statement->fetch()) {
            //Месяц из столбца даты перевода буквами
            $month = date('F', strtotime($row['trdate']));
            //проверяем есть ли уже операции в этом месяце
            if(isset($payments_value[$month])){//если есть получаем текущий баланс
                $current = $payments_value[$month];
            } else{//иначе баланс нулевой
                $current = 0;
            }
            //проверяем это пополнение или перевод
            if($row['account_from']==$value){//если перевод, снимаем
                $current-=$row['amount'];
            }elseif($row['account_to']==$value){//если пополнение, добавляем
                $current+=$row['amount'];
            }
            //Присваеваем текущее значение
            $payments_value[$month] = $current;
        }
    }
    return $payments_value;
}