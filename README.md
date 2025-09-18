# Channels DVR Station Search & M3U Generator

This application allows you to search for stations from your Channels DVR server, select desired channels, and generate a custom M3U playlist. You can then download or copy this playlist for use with other media players or services.

The application is served via a lightweight, multi-container Docker setup using Nginx and PHP-FPM for optimal performance and a small footprint.

## Features

  * **Search and Filter:** Easily find Channels DVR stations by name, call sign, channel number, station ID, and more.
  * **Select Channels:** Interactively select individual channels to include in your playlist.
  * **Custom M3U8 URLs:** For each selected channel, you can provide a specific M3U8 stream URL.
  * **M3U Generation:** Generate a standard EXTM3U playlist based on your selections.
  * **Download & Copy:** Download the generated M3U file or copy its content directly to your clipboard.
  * **Multi-Arch Support:** Docker images are available for `linux/amd64` and `linux/arm64`, supporting a wide range of devices from standard PCs to Raspberry Pis.

## Prerequisites

To run this application, you will need:

  * A running Channels DVR Server.
  * [Docker](https://www.docker.com/get-started) and [Docker Compose](https://docs.docker.com/compose/install/).

-----

## Quick Start (Using Pre-Built Docker Hub Images)

This is the fastest and easiest way to get the application running. It pulls the pre-built images directly from Docker Hub.

1.  **Create a `docker-compose.yml` file** with the following content.

    ```yaml
    version: '3.8'
    services:
      nginx:
        image: rcvaughn2/cdvr-station-search-nginx:latest
        ports:
          - "5003:80"
        depends_on:
          - php-fpm
        restart: unless-stopped

      php-fpm:
        image:  rcvaughn2/cdvr-station-search-php:latest
        environment:
          - CHANNELS_DVR_IP=${CHANNELS_DVR_IP}
        restart: unless-stopped
    ```

2.  **Create an `.env` file** in the same directory as your `docker-compose.yml`. This file will store the IP address of your Channels DVR server.

    ```
    # Replace with the IP address of your Channels DVR server
    e.g. CHANNELS_DVR_IP=192.168.86.64
    ```

3.  **Start the application** by running the following command in your terminal:

    ```bash
    docker-compose up -d
    ```

4.  **Access the Application:** Open your web browser and navigate to `http://localhost:5003`.

-----

## Local Development (Building from Source)

Follow these instructions if you have cloned the repository and want to build the Docker images yourself.

1.  **Clone the Repository:**

    ```bash
    git clone https://github.com/nuken/CDVR-Station-Search-M3U-Generator.git
    cd CDVR-Station-Search-M3U-Generator
    ```

2.  **Create the Environment File:** Create a file named `.env` in the root of the project. Add the IP address of your Channels DVR server to this file:

    ```
    # Replace with the IP address of your Channels DVR server
    e.g. CHANNELS_DVR_IP=192.168.86.64
    ```

3.  **Build and Run with Docker Compose:** Use the `docker-compose.yml` file included in the repository to build and start the services.

    ```bash
    # This command will build the images and start the containers in detached mode
    docker-compose up -d --build
    ```

4.  **Access the Application:** Open your web browser and navigate to `http://localhost:5003` (or `http://your-docker-host-ip:5003` if Docker is running on a different machine).

## Usage

1.  **Initial Load:** The application will attempt to fetch stations from your Channels DVR server.
2.  **Search for Stations:** Use the search bar to filter channels by name, call sign, etc.
3.  **View All Stations:** Click "View All Stations" to see a complete list.
4.  **Select Channels:** Check the box on any channel card to include it in your playlist.
5.  **Enter M3U8 URLs:** For each selected channel, you **must enter a valid M3U8 stream URL** in the input field that appears.
6.  **Generate M3U Playlist:** Once all selected channels have a URL, click the "Generate M3U Playlist" button.
7.  **Download or Copy:** Use the "Download M3U" or "Copy to Clipboard" buttons to save your generated playlist.

## Troubleshooting

  * **"Error loading stations: Could not connect to Channels DVR server..."**:
      * Ensure your Channels DVR server is running.
      * Double-check that the `CHANNELS_DVR_IP` in your `.env` file is correct and reachable from the machine running Docker.
      * Check the container logs for more specific errors: `docker-compose logs php-fpm`.
  * **Application is not accessible at `localhost:5003`**:
      * Verify the containers are running with `docker-compose ps`.
      * Check the Nginx container logs for startup errors: `docker-compose logs nginx`.
  * **"Please provide an M3U8 URL for all selected channels."**:
      * You must enter a stream URL for every channel you have selected before you can generate the playlist.

## Development Notes

  * The application is split into two containers:
    1.  **`nginx`**: A lightweight web server that serves the `index.html` file and proxies PHP requests.
    2.  **`php-fpm`**: Processes the `proxy.php` script, which fetches station data from the Channels DVR server API. This proxy is necessary to avoid CORS (Cross-Origin Resource Sharing) browser errors.

  * The setup is configured for automatic builds and pushes to Docker Hub via GitHub Actions.


