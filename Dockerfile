# Use the official Nginx Alpine image as a base
FROM nginx:alpine

# Copy the static HTML file
COPY src/index.html /var/www/html/

# Copy the custom Nginx configuration
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Expose port 80
EXPOSE 80

# The default Nginx command will run, so no CMD is needed