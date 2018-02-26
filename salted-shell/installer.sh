#!/bin/bash

# default config
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
    result=`mysql -uroot -p$sqlRootPass -h$sqlSer -D $sqlDbName -e " CREATE TABLE $sqlTableUsers (  \
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
    result=`mysql -uroot -p$sqlRootPass -h$sqlSer -D $sqlDbName -e "CREATE TABLE $sqlTableGoods(  \
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
        goods_heat     INT NOT NULL DEFAULT 0,      \
        goods_sv       INT NOT NULL DEFAULT 0,      \
        goods_pv       INT NOT NULL DEFAULT 0,      \
        goods_tu       INT NOT NULL DEFAULT 0,      \
        PRIMARY KEY (goods_id)                      \
        );" 2>>$errLogFile`
    if [ "$?" -ne "0" ]; then
        echo "error"
    else
        echo "done."
    fi

    echo -e "Creating order table......\c"
    result=`mysql -uroot -p$sqlRootPass -h$sqlSer -D $sqlDbName -e "CREATE TABLE $sqlTableOrders(  \
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
    result=`mysql -uroot -p$sqlRootPass -h$sqlSer -D $sqlDbName -e "CREATE TABLE $sqlTableSession(  \
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
    result=`mysql -uroot -p$sqlRootPass -h$sqlSer -D $sqlDbName -e "CREATE TABLE $sqlTableMessage(    \
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
}

function grant_privileges(){
    read -n1 -p "Do you want to refresh privileges? (y/N) "
    echo ""
    if [[ "$REPLY" = "Y" || "$REPLY" = "y" ]];then 
        if [[ ! "$sqlSerUser" = "root" && -z "$sqlRootPass" ]];then    # 如果没有root密码
            read -s -p "root password is required to continue (Press enter to skip) "
            if [ -z $REPLY ]; then
                echo " ...... skip"
                return
            fi
            sqlRootPass=$REPLY
        fi
        echo -e "Grant privileges on $sqlDbName to $sqlSerUser......\c"
        result=`mysql -uroot -p$sqlRootPass -h$sqlSer -e " GRANT ALL PRIVILEGES ON $sqlDbName.* TO $sqlSerUser@'%' IDENTIFIED BY '$sqlSerPass';" 2>>$errLogFile`
        if [ "$?" -ne "0" ]; then
            echo "error"
        else
            echo "done."
        fi
        echo -e "Refreshing privileges......\c"
        result=`mysql -uroot -p$sqlRootPass -h$sqlSer -e "FLUSH PRIVILEGES;" 2>>$errLogFile`
        if [ "$?" -ne "0" ]; then
            echo "error"
        else
            echo "done."
        fi
    fi
}

function create_test_user(){
    while true
    do
        read -n1 -p "Create a test account? (Y/n) "
        if [[ "$REPLY" = "N" || "$REPLY" = "n" ]];then 
            echo "    ...... skip"
            break
        fi
        echo ""
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
    read -n1 -p "Do you want to generate config.php? (Y/n) "
    if [[ "$REPLY" = "N" || "$REPLY" = "n" ]];then
        echo "    ...... skip"
        return
    fi
    echo -e "\nGenerating config.php......\c"
    echo -e "<?php\n\n\$db_host = \"$sqlSer\";\n\$db_user = \"$sqlSerUser\";\n\$db_pass = \"$sqlSerPass\";\n\$db_name = \"$sqlDbName\";\n\$db_users_table = \"$sqlTableUsers\";\n\$db_goods_table = \"$sqlTableGoods\";\n\$db_order_table = \"$sqlTableOrders\";\n\$db_session_table = \"$sqlTableSession\";\n\$db_message_table = \"$sqlTableMessage\";    \n\n\$addons = array(\n\t\"ueditor\" => \"../addons/ueditor/php\"\n);    \n\ndate_default_timezone_set('Asia/Chongqing');\n?>" > $configFile
    echo "done."
}

function input_mysql_tables_config(){

    read -n1 -p "Do you want manually config database tables? (y/N) "
    echo ""
    if [[ "$REPLY" = "n" || "$REPLY" = "N" ]];then 
        return
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
}

function mysql_database_config(){   # 此时用户有权限（查询）
    result=`mysql -u$sqlSerUser -p$sqlSerPass -h$sqlSer -e "SELECT * FROM information_schema.SCHEMATA where SCHEMA_NAME='$sqlDbName'" 2>>$errLogFile`
    if [ "$?" -ne "0" ]; then
        echo "Your mysql may not be configured correctly,or username and password mismatch."
        echo "Configure exited"
        exit
    fi

    if [ -z "$result" ]; then   # 数据库不存在
        if [[ ! "$sqlSerUser" = "root" && -z "$sqlRootPass" ]];then    # 如果没有root密码
            read -s -p "Database does not exist, root password is required to create a database (Press enter to exit) "
            if [ -z $REPLY ]; then
                exit
            fi
            sqlRootPass=$REPLY
        fi
        if [[ "$sqlSerUser" == "root" ]];then
            sqlRootPass=$sqlSerPass
        fi
        echo -e "Creating database.......\c"
        result=`mysql -uroot -p$sqlRootPass -h$sqlSer -e " CREATE DATABASES $sqlDbName" 2>>$errLogFile`
        if [ "$?" -ne "0" ]; then
            echo ""
            echo "Your mysql may not be configured correctly,or username and password mismatch."
            echo "Configure exited"
            exit
        else
            echo "done"
        fi
        input_mysql_tables_config
        create_db_table
    else
        read -n1 -p "Do you want to clear and rebuild database? (y/N) "
        echo ""
        if [[ "$REPLY" = "Y" || "$REPLY" = "y" ]];then 
            if [[ ! "$sqlSerUser" = "root" && -z "$sqlRootPass" ]];then    # 如果没有root密码
                read -s -p "root password is required to continue (Press enter to skip) "
                if [ -z $REPLY ]; then
                    echo " ...... skip"
                    return
                fi
                sqlRootPass=$REPLY
            fi
            echo -e "\nDropping database......\c"
            result=`mysql -uroot -p$sqlRootPass -h$sqlSer -e "DROP DATABASE $sqlDbName;  " 2>>$errLogFile`
            if [ "$?" -ne "0" ]; then
                echo "error"
                exit
            else
                echo "done"
            fi
            echo -e "Creating database......\c"
            result=`mysql -uroot -p$sqlRootPass -h$sqlSer -e "CREATE DATABASE $sqlDbName;;  " 2>>$errLogFile`
            if [ "$?" -ne "0" ]; then
                echo "error"
                exit
            else
                echo "done"
            fi
            input_mysql_tables_config
            create_db_table
        else
            echo "    ...... skip"
        fi
    fi
}

function mysql_database_drop(){
    echo -e "\nDropping database......\c"
    result=`mysql -uroot -p$sqlRootPass -h$sqlSer -e "DROP DATABASE $sqlDbName;  " 2>>$errLogFile`
    if [ "$?" -ne "0" ]; then
        echo "error"
        exit
    else
        echo "done"
    fi
}

function mysql_database_create(){
    echo -e "\nCreating database......\c"
    result=`mysql -uroot -p$sqlRootPass -h$sqlSer -e " CREATE DATABASE $sqlDbName" 2>>$errLogFile`
    if [ "$?" -ne "0" ]; then
        echo ""
        echo "Your mysql may not be configured correctly,or username and password mismatch."
        echo "Configure exited"
        exit
    else
        echo "done"
    fi
    input_mysql_tables_config
    create_db_table
}

function main(){
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

    # 检查数据库是否存在
    result=`mysql -u$sqlSerUser -p$sqlSerPass -h$sqlSer -e "SELECT * FROM information_schema.SCHEMATA where SCHEMA_NAME='$sqlDbName'" 2>>$errLogFile`
    if [ "$?" -ne "0" ]; then
        if [ "$sqlSerUser" = "root" ];then
            echo "Your mysql may not be configured correctly,or username and password mismatch."
            exit
        fi
        echo "Your mysql may not be configured correctly or no such user"
        read -s -p "Enter root password to create this user(Press enter to skip) "
        echo ""
        if [ ! -z $REPLY ];then 
            sqlRootPass=$REPLY
            echo -e "Creating database user $sqlSerUser......\c"
            result=`mysql -uroot -p$sqlRootPass -h$sqlSer -e "CREATE USER '$sqlSerUser'@'*' IDENTIFIED BY '$sqlSerPass';" 2>>$errLogFile`
            if [ "$?" -ne "0" ]; then
                echo "error"
                echo "Your mysql may not be configured correctly,or username and password mismatch."
                exit
            else
                echo "done"
            fi
        else
            exit
        fi
    fi
    if [ -z "$result" ]; then   # 数据库不存在(或者没有权限)
        if [ ! "$sqlSerUser" = "root" ];then    # 可能是没有权限的情况
            echo ""
            if [ -z $sqlRootPass ];then
                echo "No such database or no enough privileges"
                read -s -p "Enter root password to continue. (Press enter to exit) "   # 输入root密码
                echo ""
                if [ -z $REPLY ]; then
                    exit
                fi
                sqlRootPass=$REPLY
            fi
            # 用root查询
            result=`mysql -uroot -p$sqlRootPass -h$sqlSer -e "SELECT * FROM information_schema.SCHEMATA where SCHEMA_NAME='$sqlDbName'" 2>>$errLogFile`
            if [ "$?" -ne "0" ]; then
                echo "Your mysql may not be configured correctly,or username and password mismatch."
                exit
            fi
            if [ -z "$result" ]; then   # 如果还是没有数据库
                read -n1 -p "Do you want to create database ($sqlDbName)? (Y/n) "
                if [[ "$REPLY" = "N" || "$REPLY" = "n" ]];then 
                    # do nothing
                    echo " ...... skip"
                else
                    mysql_database_create
                fi
            else            # 如果是没有权限（有数据库）
                echo "Your account $sqlSerUser has no enough privileges."
                grant_privileges
                mysql_database_config
            fi
        else # 没有数据库的情况(用户为root)
            read -n1 -p "Do you want to create database ($sqlDbName)? (Y/n) "
            if [[ "$REPLY" = "N" || "$REPLY" = "n" ]];then 
                echo " ...... skip"
            else
                sqlRootPass=$sqlSerPass
                mysql_database_create
            fi
        fi
    else    # 有数据库的情况(不知道用户是谁，但是有查询权限)
        read -n1 -p "Do you want to config database? (y/N) "
        if [[ "$REPLY" = "Y" || "$REPLY" = "y" ]];then 
            echo ""
            sqlRootPass=$sqlSerPass
            mysql_database_config
        else
            echo "    ...... skip"
        fi
    fi
    grant_privileges
    create_test_user
    generate_config_file
    echo -e "\nConfig done."
}

main