#!/bin/bash

errLogFile="install_err_log.txt"
configFile="config.php"
sqlSer="127.0.0.1"
sqlSerUser="ibeike_test"
sqlSerPass="ibeike_test"
sqlRootPass=""
sqlDbName="ibeike_test"
sqlTableUsers="salted_fish_users"
sqlTableGoods="salted_fish_goods"
sqlTableOrders="orders"
sqlTableSession="session"
sqlTableMessage="messages"

studentInfo="%7B%22student_id%22%3A%7B%22access%22%3A%22public%22%2C%22value%22%3A%22REPLACESTUDENTID%22%7D%2C%22name%22%3A%7B%22access%22%3A%22public%22%2C%22value%22%3A%22%5Cu5f20%5Cu5cfb%5Cu950b%22%7D%2C%22gender%22%3A%7B%22access%22%3A%22public%22%2C%22value%22%3A%22%5Cu7537%22%7D%2C%22birthday%22%3A%7B%22access%22%3A%22protected%22%2C%22value%22%3A%2220160101%22%7D%2C%22type%22%3A%7B%22access%22%3A%22private%22%2C%22value%22%3A%22%5Cu672c%5Cu79d1%22%7D%2C%22nationality%22%3A%7B%22access%22%3A%22private%22%2C%22value%22%3A%22%5Cu6c49%5Cu65cf%22%7D%2C%22nickname%22%3A%22%5Cu4e8c%5Cu72d7%5Cu5b50%22%2C%22header%22%3A%22..%2fcss%2fdefault-header.jpg%22%2C%22class_info%22%3A%7B%22access%22%3A%22protected%22%2C%22department%22%3A%7B%22access%22%3A%22public%22%2C%22value%22%3A%22%5Cu9b54%5Cu6cd5%5Cu5b66%5Cu9662%22%7D%2C%22enrollment%22%3A%7B%22access%22%3A%22public%22%2C%22value%22%3A%222016%22%7D%2C%22class_no%22%3A%7B%22access%22%3A%22public%22%2C%22value%22%3A%22%5Cu80fd%5Cu6e901605%22%7D%7D%2C%22dormitory%22%3A%7B%22access%22%3Anull%2C%22dormitory_id%22%3A%7B%22access%22%3A%22protected%22%2C%22value%22%3A%225%22%7D%2C%22room_no%22%3A%7B%22access%22%3A%22public%22%2C%22value%22%3A%22666%22%7D%2C%22value%22%3Anull%7D%2C%22phone_number%22%3A%7B%22access%22%3A%22protected%22%2C%22value%22%3A%2213996309201%22%7D%2C%22department%22%3A%7B%22access%22%3A%22protected%22%2C%22value%22%3A%22%5Cu9b54%5Cu6cd5%5Cu5b66%5Cu9662%22%7D%7D"

function create_db_table(){
    echo -e "Creating user table.......\c"
    result=`mysql -u$sqlSerUser -p$sqlSerPass -h$sqlSer -D $sqlDbName -e " CREATE TABLE $sqlTableUsers (  \
        student_id      CHAR(16) NOT NULL,  \
        student_pass    CHAR(32) NOT NULL,  \
        pass_salt       CHAR(8)  NOT NULL,  \
        student_info    TEXT,               \
        info_hash       CHAR(64),           \
        account_header  VARCHAR(64),        \
        bbs_id          CHAR(32),           \
        PRIMARY KEY(student_id)             \
    );" 2>>$errLogFile`
    if [ "$?" -ne "0" ]; then
        echo "error"
    else
        echo "done."
    fi
    

    echo -e "Creating goods table......\c"
    result=`mysql -u$sqlSerUser -p$sqlSerPass -h$sqlSer -D $sqlDbName -e "CREATE TABLE $sqlTableGoods(  \
        goods_id       INT NOT NULL AUTO_INCREMENT, \
        goods_title    VARCHAR(128) NOT NULL,       \
        goods_img      VARCHAR(256) NOT NULL,       \
        goods_status   CHAR(32) NOT NULL,           \
        goods_type     CHAR(32) NOT NULL,           \
        single_cost    CHAR(64) NOT NULL,           \
        remain         INT NOT NULL,                \
        goods_owner    CHAR(16) NOT NULL,           \
        ttm            DATETIME NOT NULL,           \
        last_modified  DATETIME NOT NULL,           \
        delivery_fee   INT NOT NULL,                \
        search_summary TEXT,                        \
        goods_info     TEXT,                        \
        comments       TEXT,                        \
        tags           VARCHAR(128),                \
        cl_lv_1        VARCHAR(128),                \
        cl_lv_2        VARCHAR(128),                \
        cl_lv_3        varchar(128),                \
        goods_heat     INT NOT NULL,                \
        goods_sv       INT NOT NULL,                \
        goods_pv       INT NOT NULL,                \
        goods_tu       INT NOT NULL,                \
        PRIMARY KEY (goods_id)                      \
        );" 2>>$errLogFile`
    if [ "$?" -ne "0" ]; then
        echo "error"
    else
        echo "done."
    fi

    echo -e "Creating order table......\c"
    result=`mysql -u$sqlSerUser -p$sqlSerPass -h$sqlSer -D $sqlDbName -e "CREATE TABLE $sqlTableOrders(  \
            order_id         INT NOT NULL AUTO_INCREMENT,   \
            order_type       CHAR(16) NOT NULL,             \
            goods_id         INT NOT NULL,                  \
            rent_duration    INT,                           \
            order_submitter  CHAR(16) NOT NULL,             \
            ordering_date    TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),    \
            single_cost      INT NOT NULL,                  \
            delivery_fee     FLOAT NOT NULL,                \
            purchase_amount  INT NOT NULL,                  \
            offer            FLOAT NOT NULL,                \
            order_status    CHAR(16) NOT NULL,              \
            PRIMARY KEY(order_id)                           \
        );" 2>>$errLogFile`
    if [ "$?" -ne "0" ]; then
        echo "error"
    else
        echo "done."
    fi

    echo -e "Creating session table......\c"
    result=`mysql -u$sqlSerUser -p$sqlSerPass -h$sqlSer -D $sqlDbName -e "CREATE TABLE $sqlTableSession(  \
            session_key     CHAR(32) NOT NULL,  \
            student_id      CHAR(16) NOT NULL,  \
            ttl             INT      ,  \
            vaild_date      DATETIME ,  \
            PRIMARY KEY(session_key)    \
        );"  2>>$errLogFile`
    if [ "$?" -ne "0" ]; then
        echo "error"
    else
        echo "done."
    fi

    echo -e "Creating message table......\c"
    result=`mysql -u$sqlSerUser -p$sqlSerPass -h$sqlSer -D $sqlDbName -e "CREATE TABLE $sqlTableMessage(    \
        msg_id INT NOT NULL AUTO_INCREMENT, \
        msg_content TEXT,                   \
        msg_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,     \
        sender_id CHAR(16) NOT NULL,        \
        recver_id CHAR(16) NOT NULL,        \
        has_read    BOOLEAN NOT NULL DEFAULT FALSE, \
        PRIMARY KEY(msg_id) \
    );" 2>>$errLogFile`
    if [ "$?" -ne "0" ]; then
        echo "error"
    else
        echo "done."
    fi

    while true
    do
        echo ""
        read -p "Create a test account? (Y/n) "
        if [[ "$REPLY" = "N" || "$REPLY" = "n" ]];then 
            break
        fi
        read -p "Student ID (8 digit number): " uname
        read -s -p "Password: " pword
        echo ""
        if [[ -z $uname || -z $pword  ]]; then
            read -p "Username or password can not be null, press any key to continue."
            continue
        fi
        uname=`echo $uname | head -c 8`
        # get salt
        salt=`echo $RANDOM | md5sum | head -c 8`
        # get md5 password 
        md5pword=`echo -n $pword | md5sum | head -c 32 `
        # get salted md5 password
        md5pword=`echo -n $md5pword$salt | md5sum | head -c 32`

        echo -e "Creating user $uname......\c"

        result=`mysql -u$sqlSerUser -p$sqlSerPass -h$sqlSer -D $sqlDbName -e    \
            "INSERT INTO $sqlTableUsers(student_id,student_pass,pass_salt,student_info)    \
            VALUES ('$uname','$md5pword','$salt','${studentInfo/REPLACESTUDENTID/$uname}')" 2>>$errLogFile`
        if [ "$?" -ne "0" ]; then
            echo "error"
        else
            echo "done."
        fi
    done
}

function generate_config_file(){
    echo ""
    read -p "Update config.php? (Y/n) "
    if [[ "$REPLY" = "N" || "$REPLY" = "n" ]];then
        return
    fi
    echo -e "generating config.php......\c"
    echo -e "<?php\n\n\$db_host = \"$sqlSer\";\n\$db_user = \"$sqlSerUser\";\n\$db_pass = \"$sqlSerPass\";\n\$db_name = \"$sqlDbName\";\n\$db_users_table = \"$sqlTableUsers\";\n\$db_goods_table = \"$sqlTableGoods\";\n\$db_order_table = \"$sqlTableOrders\";\n\$db_session_table = \"$sqlTableSession\";\n\$db_message_table = \"$sqlTableMessage\";    \n\n\$addons = array(\n\t\"ueditor\" => \"../addons/ueditor/php\"\n);    \n\ndate_default_timezone_set('Asia/Chongqing');\n?>" > $configFile
    echo "done."
}

read -p "Input Mysql Server Address (Default $sqlSer): "
if [ ! -z $REPLY ]; then
    sqlSer=$REPLY
fi

read -p "Input Mysql Server User (Default $sqlSerUser): " 
if [ ! -z $REPLY ]; then
    sqlSerUser=$REPLY
fi


read -s -p "Input Mysql Server Pass (Default $sqlSerPass): " 
if [ ! -z $REPLY ]; then
    sqlSerPass=$REPLY
fi

echo ""

read -p "Input Mysql Database Name (Default $sqlDbName): " 
if [ ! -z $REPLY ]; then
    sqlDbName=$REPLY
fi


read -p "Input Database user table (Default $sqlTableUsers): " 
if [ ! -z $REPLY ]; then
    sqlTableUsers=$REPLY
fi


read -p "Input Database goods table (Default $sqlTableGoods): " 
if [ ! -z $REPLY ]; then
    sqlTableGoods=$REPLY
fi


read -p "Input Database orders table (Default $sqltableOrders): " 
if [ ! -z $REPLY ]; then
    sqlTableOrders=$REPLY
fi


read -p "Input Database session table (Default $sqlTableSession): " 
if [ ! -z $REPLY ]; then
    sqlTableSession=$REPLY
fi

echo ""

result=`mysql -u$sqlSerUser -p$sqlSerPass -h$sqlSer -e "SELECT * FROM information_schema.SCHEMATA where SCHEMA_NAME='$sqlDbName'" 2>>$errLogFile`
if [ "$?" -ne "0" ]; then
    echo "Your mysql may not be configured correctly,or username password mismatch."
    echo "Configure exited"
    exit
fi

if [ -z "$result" ]; then   # 数据库不存在
    echo -e "Database has not been created, creating.......\c"
    result=`mysql -u$sqlSerUser -p$sqlSerPass -h$sqlSer -e " CREATE DATABASES $sqlDbName 2>>$errLogFile"`
    if [ "$?" -ne "0" ]; then
        echo ""
        read -p "Your mysql may not be configured correctly,or lack of authority, continue? (Y/n) "
        if [[ "$REPLY" = "N" || "$REPLY" = "n" ]];then
            echo "Configure exited"
            exit
        fi
    else
        echo "done"
    fi
else
    read -p "Do you want to clear and rebuild databases? (y/N) "
    if [[ "$REPLY" = "Y" || "$REPLY" = "y" ]];then 
        if [[ ! "$sqlSerUser" = "root" ]];then
            read -p "Root password required(No password will exit): "
            if [ -z "$REPLY" ];then
                echo "Configure exit."
                exit
            fi
            sqlRootPass=$REPLY
        else
            sqlRootPass=$sqlSerPass
        fi
        echo -e "Dropping databases......\c"
        result=`mysql -uroot -p$sqlRootPass -h$sqlSer -e " DROP DATABASE $sqlDbName " 2>>$errLogFile`
        if [ "$?" -ne "0" ]; then
            echo "error"
            exit
        else
            echo "done"
        fi

        echo -e "Creating databases......\c"
        result=`mysql -uroot -p$sqlRootPass -h$sqlSer -e " CREATE DATABASE $sqlDbName"  2>>$errLogFile`
        if [ "$?" -ne "0" ]; then
            echo "error"
            exit
        else
            echo "done"
        fi
    else
        generate_config_file

        exit
    fi
fi

echo -e "\nCreating database tables......"

create_db_table

generate_config_file

echo -e "\nConfigure done."
