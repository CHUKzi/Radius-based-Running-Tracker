# Circular Playground Runner

Circular Playground Runner is a web-based application developed using PHP, MySQL, and HTML Bootstrap. It allows runners to record and track their running activities in a perfectly circular playground with a variable radius. The application provides features such as run recording, radius settings, on-the-fly reporting, and more.

## Features

- **Radius Setting**: Set and store the current radius of the playground for each run.
- **Run Recording**: Record runner name, radius, start time, end time, and number of laps for each running session.
- **Validation**: Reject any run with a radius larger than the playground's specified radius.
- **On-the-Fly Reporting**: Generate reports with the average speed of each running session.
- **Responsive UI**: Built with HTML Bootstrap for a mobile-friendly and visually appealing user interface.

## Requirements

- PHP 7.0 or higher
- MySQL database
- HTML Bootstrap framework

## Installation

1. Clone this repository to your web server or local machine.
2. Import the database schema using the provided SQL file (`running_events_db.sql`).
3. Configure the database connection settings in the `connection.php` file.
4. Start your web server and ensure PHP is properly configured.
5. Access the application through your web browser.

## Usage

1. Set the radius of the playground in the application settings.
2. Record each running session by providing runner details, radius, start time, end time, and number of laps.
3. View on-the-fly reports to analyze the average speed of each running session.

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, please open an issue or submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).
