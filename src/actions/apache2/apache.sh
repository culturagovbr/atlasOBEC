echo "[******] Copying and enable virtualhost 'site.conf'";
cp /tmp/src/actions/apache2/sites-available/site.conf /etc/apache2/sites-available/site.conf

echo "[******] Enable Apache Mod CGI";
a2enmod cgi

echo "[******] Enable Site Atlas";
a2ensite site.conf

echo "[******] Restarting Apache 2 Service";
service apache2 reload

echo "[******] Starts Apache using Foreground Mode";
apache2ctl -D FOREGROUND
