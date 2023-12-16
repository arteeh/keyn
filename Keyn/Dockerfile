FROM mcr.microsoft.com/dotnet/sdk:8.0 AS build
RUN apt-get update
RUN apt-get install -y python3 libatomic1
RUN dotnet workload install wasm-tools
WORKDIR /app
COPY . ./
RUN dotnet publish --sc -o publish

FROM nginx as run
WORKDIR /usr/share/nginx/html
COPY --from=build /app/publish/wwwroot .
COPY ./nginx.conf /etc/nginx/nginx.conf
EXPOSE 80