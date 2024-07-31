FROM mcr.microsoft.com/dotnet/sdk:8.0 AS build
RUN apt-get update && apt-get install -y python3 libatomic1 && dotnet workload install wasm-tools
WORKDIR /app
COPY . ./
RUN dotnet publish -o publish

FROM nginx as run
COPY --from=build /app/publish/wwwroot /usr/share/nginx/html
COPY ./nginx.html /etc/nginx/nginx.conf
EXPOSE 80