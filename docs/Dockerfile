FROM node:alpine
USER node
WORKDIR /home/node
EXPOSE 8080
RUN mkdir -p public && npm i http-server
COPY --chown=node:node index.html artifacts/docs  ./public/
CMD ["node_modules/.bin/http-server", "--port", "8080", "./public"]
