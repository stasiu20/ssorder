FROM node:12.16-alpine
USER node
WORKDIR /home/node
COPY --chown=node:node package.json package-lock.json ./
RUN npm ci --only=production
COPY --chown=node:node ./src/ ./src/
CMD [ "node", "src/index.js" ]
