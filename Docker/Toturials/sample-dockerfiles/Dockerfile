# from the base image ubuntu starting to make a new image (modified ubuntu image)

FROM ubuntu

MAINTAINER Bablu Ahmed <bablukpik@gmail.com>

RUN apt-get update

CMD ["echo", "Hello World! from my new ubuntu image"]


# docker build . - for building an image
# docker build -t registryhost/username/imageName:tagName 'Location of Dockerfile'
# N.B: here -t or --tag is registryhost/username/imageName:tagName format to be pushed
