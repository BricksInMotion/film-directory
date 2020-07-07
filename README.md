# BiM Film Directory Archive
> An archive for the Bricks in Motion film directory

## Brief

[Bricks in Motion](https://www.bricksinmotion.com/) is a friendly filmmaking community devoted to the art of stop-motion animation. [Since 2009](https://www.bricksinmotion.com/forums/post/45237/), BiM has kept a film directory where brickfilm animators can submit their films. However, after running for over 10 years, the directory has become a logical mess and a nightmare to maintain and bug fix, yet remains popular and receives film submissions daily.

As part of a larger forum upgrade, the directory became incompatible on a technical level due to a deep integration with the original forum software, but the submitted films were desired to be preserved for posterity purposes.

In that light, the purpose of this project is to provide a modern browsing experience for the BiM film directory using the original database structure, making structure/design improvements when deemed helpful.

## Usage

1. `$ touch ./secrets/api_server`
1. `$ touch ./secrets/api_key`
1. Set API secrets
1. `$ docker build -f "docker/Dockerfile" -t bim-film-directory:latest .`

## License

[MIT](LICENSE)

2018-2020 Caleb Ely
