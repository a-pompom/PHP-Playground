FROM mariadb:10.6
ENV TZ=Asia/Tokyo

# 設定ファイル
COPY "./conf/my.cnf" "/etc/mysql/conf.d/custom_my.cnf"
# 初期化スクリプト
COPY "./init.sh" "/docker-entrypoint-initdb.d/init.sh"

# ユーザ設定
USER mysql

VOLUME /var/lib/mysql
EXPOSE 3306
