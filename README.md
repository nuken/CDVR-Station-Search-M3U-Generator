# Channels DVR Station Search & M3U Generator

This application allows you to search for stations from your Channels DVR server, select desired channels, and generate a custom M3U playlist. You can then download or copy this playlist for use with other media players or services.

## Features

* **Search and Filter:** Easily find Channels DVR stations by name, call sign, channel number, station ID, and more.
* **Select Channels:** Interactively select individual channels to include in your playlist.
* **Custom M3U8 URLs:** For each selected channel, you can provide a specific M3U8 stream URL, allowing for flexible playlist creation.
* **M3U Generation:** Generate a standard EXTM3U playlist based on your selections and provided URLs.
* **Download & Copy:** Download the generated M3U file or copy its content directly to your clipboard.
* **Dynamic UI:** The interface dynamically updates based on your search and selections.

## Prerequisites

To use this application, you need:

1. **A running Channels DVR Server:** The application connects to your local Channels DVR instance to fetch station information.
2. **Docker:** To build and run the provided Docker image.

## Setup and Installation

1. **Download and extract the zip file:** You should be left with a folder containing a `Dockerfile` and a `src` directory containing `index.html` and `proxy.php` files.

2. **Build the Docker Image:** Open your terminal or command prompt, navigate to the directory containing your `Dockerfile` and `src` folder, and run the following command:

3. ```bash
   docker build -t channels-m3u8 .
   ```
   
   This command builds a Docker image named `channels-m3u8`.

4. **Run the Docker Container:** Once the image is built, you can run the container using the following command. **Remember to replace `192.168.86.64` with the actual IP address of your Channels DVR server.**
   
   ```bash
   docker run -d --restart unless-stopped -p 5003:80 -e CHANNELS_DVR_IP=192.168.86.64 --name channels-m3u8 channels-m3u8
   ```
   
   * `-d`: Runs the container in detached mode (in the background).
   * `--restart unless-stopped`: The container will automatically restart unless it is explicitly stopped.
   * `-p 5003:80`: Maps port `5003` on your host machine to port `80` inside the container. You can pick any open and available port you want to. 
   * `-e CHANNELS_DVR_IP=192.168.86.64`: Sets the `CHANNELS_DVR_IP` environment variable inside the container to the IP address of your Channels DVR server. The `proxy.php` uses this environment variable to connect to your Channels DVR.
   * `--name channels-m3u8`: Assigns the name `channels-m3u8` to your container for easy management.
   * `channels-m3u8`: The name of the Docker image to run.

## Usage

1. **Access the Application:** Open your web browser and navigate to `http://localhost:5003` (or `http://your_docker_host_ip:5003` if Docker is running on a different machine).
2. **Initial Load:** The application will attempt to fetch stations from your Channels DVR server. If successful, you will see an initial message prompting you to search or view all stations. If there's an error connecting, an error message will be displayed.
3. **Search for Stations:**
   * Type a keyword (e.g., "NBC", "2.1", "HBO", "ESPN") into the "Start typing to search for channels..." input field.
   * The results will dynamically update as you type.
   * Click "Clear Search" to remove the search term and hide results.
4. **View All Stations:**
   * Click the "View All Stations" button to display all available channels from your Channels DVR server. This button will change to "Hide Stations" allowing you to collapse the list.
5. **Select Channels:**
   * For each channel you want to include in your M3U playlist, check the checkbox in the top-left corner of its card.
   * When you check a box, an "Enter M3U8 URL" input field will appear on that card.
6. **Enter M3U8 URLs:**
   * For each selected channel, **you must enter a valid M3U8 stream URL** into the input field that appears. This is the actual stream URL that your player will use.
7. **Generate M3U Playlist:**
   * Once you have selected channels and provided M3U8 URLs for all of them, the "Generate M3U Playlist" button will become enabled.
   * Click this button to generate the M3U content in the textarea below.
8. **Download or Copy M3U:**
   * After the M3U playlist is generated, the "Download M3U" and "Copy to Clipboard" buttons will become enabled.
   * Click "Download M3U" to save the playlist as a `.m3u` file (e.g., `channels_dvr_playlist.m3u`).
   * Click "Copy to Clipboard" to copy the entire M3U content to your system clipboard.

## Troubleshooting

* **"Error loading stations: Could not connect to Channels DVR server..."**:
  * Ensure your Channels DVR server is running.
  * Verify the IP address (`192.168.86.64` in the example `docker run` command) is correct and reachable from where your Docker container is running.
  * Ensure the port `8089` is correct for your Channels DVR server.
  * Check your Docker container logs for more specific error messages: `docker logs channels-m3u8`.
* **No stations appear after searching/viewing all:**
  * This could also indicate a connection issue to the Channels DVR server. Check the browser's developer console for network errors (F12, then "Console" or "Network" tab).
  * Ensure your Channels DVR server actually has stations configured and available.
* **"Please provide an M3U8 URL for all selected channels."**:
  * You must enter a stream URL for every channel you've selected before generating the M3U.
* **M3U playlist doesn't play in my media player**:
  * Double-check that the M3U8 URLs you entered are correct and valid.
  * Ensure your media player supports the HLS (M3U8) streaming format.

## Development Notes

* The `proxy.php` acts as a simple proxy to bypass potential CORS (Cross-Origin Resource Sharing) issues when the `index.html` (served from your Docker container on port `5003`) tries to fetch data directly from the Channels DVR server (which runs on a different IP and port `8089`).
* The application uses [Tailwind CSS](https://tailwindcss.com/) for styling (via CDN) and plain JavaScript for functionality.
