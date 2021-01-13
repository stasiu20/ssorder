FROM node:12.16-alpine
USER node
WORKDIR /home/node
EXPOSE 8080
RUN mkdir -p public && npm i http-server
COPY --chown=node:node index.html artifacts/docs  ./public/
CMD ["npx", "http-server", "--port", "8080", "./public"]
