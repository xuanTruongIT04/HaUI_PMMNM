TAG=$(date '+%Y%d%m.%H%M%S')

ImageName="alumni-backend"
echo "Building image $ImageName:$TAG"
docker build . -t $ImageName:$TAG
docker tag $ImageName:$TAG $ImageName:latest
