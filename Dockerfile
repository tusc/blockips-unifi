#FROM arm64v8/alpine:latest
FROM alpine:latest

RUN apk --update add composer php7-curl php7-session git tzdata && \
	composer require art-of-wifi/unifi-api-client

COPY add_block_firewall.php /
COPY del_block_firewall.php /

# requird when building arm images on x86 hardware
ADD qemu-aarch64-static /usr/bin

# build startup script
RUN echo "#!/bin/sh" > /startscript.sh
RUN echo "chown root:root /etc/crontabs/root" >> /startscript.sh
RUN echo "/usr/sbin/crond -d 8 -f" >> /startscript.sh

RUN chmod +x /startscript.sh

ENTRYPOINT ["/startscript.sh"]
