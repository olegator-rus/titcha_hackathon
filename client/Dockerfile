FROM node:16-alpine
ARG TZ=Europe/Moscow
ENV TZ ${TZ}
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
ENV APP_ROOT /web
WORKDIR ${APP_ROOT}
COPY package*.json yarn.lock ./
RUN yarn install
EXPOSE 3000
CMD ["/bin/sh", "startup.sh"]
