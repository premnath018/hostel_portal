# Hostel Portal

Hostel Portal is a web-based application designed to streamline the management of student complaints and suggestions in a hostel environment. Built using PHP, HTML, CSS, and JavaScript, the portal provides distinct interfaces for students, caretakers, and administrators to ensure efficient resolution of issues and continuous improvement of hostel facilities.

## Table of Contents
- [Introduction](#introduction)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)
- [Examples](#examples)
- [Troubleshooting](#troubleshooting)
- [Contributors](#contributors)
- [License](#license)

## Introduction

The Hostel Portal allows students to file complaints about issues in their hostel rooms, which caretakers can then confirm and assign tasks for resolution. Additionally, students can submit suggestions for hostel improvements, which other students can upvote, similar to a "like" button. This facilitates a collaborative approach to maintaining and improving hostel living conditions.

## Features

- **Student Interface**:
  - File complaints about room issues
  - Submit suggestions for hostel improvements
  - Upvote suggestions from other students

- **Caretaker Interface**:
  - View and confirm student complaints
  - Assign tasks to resolve confirmed complaints

- **Admin Interface**:
  - Manage user roles and permissions
  - Monitor overall system activity

## Technologies Used

- **PHP**: Server-side scripting
- **HTML/CSS**: Frontend structure and styling
- **JavaScript**: Client-side interactivity

## Installation

To run Hostel Portal locally, follow these steps:

1. Clone the repository:
    ```bash
    git clone https://github.com/yourusername/hostel_portal.git
    ```
2. Navigate to the project directory:
    ```bash
    cd hostel_portal
    ```
3. Set up your web server (e.g., Apache) to serve the project directory.
4. Import the provided SQL database file (`database.sql`) into your MySQL database.
5. Update the database configuration in `/api/db/connection.php` with your database credentials.

## Usage

1. Open the application in your web browser.
2. Log in using your student, caretaker, or admin credentials.
3. For students:
   - Navigate to the 'Room Query' section to submit a new complaint.
   - Go to the 'Suggestions' section to submit a new suggestion or upvote existing ones.
4. For caretakers:
   - View pending complaints in the 'Complaints' section and confirm or assign tasks.
5. For admins:
   - Manage user accounts and system settings from the admin dashboard.

## Configuration

Ensure the following configurations are set up correctly in `/api/db/connection.php`:
- Database host
- Database name
- Database user
- Database password

## Examples

### Filing a Complaint

1. Log in as a student.
2. Go to the 'Room Query' section.
3. Enter the details of the issue (e.g., broken light).
4. Submit the complaint.

### Submitting a Suggestion

1. Log in as a student.
2. Go to the 'Suggestions' section.
3. Enter your suggestion for improvement (e.g., more study rooms).
4. Submit the suggestion.

### Upvoting a Suggestion

1. Log in as a student.
2. Go to the 'Suggestions' section.
3. Find a suggestion you agree with.
4. Click the 'Upvote' button.

## Troubleshooting

- **Unable to Connect to Database**: Ensure your database credentials in `config.php` are correct and that the MySQL server is running.
- **Page Not Loading Properly**: Check for any syntax errors in PHP or JavaScript files, and ensure your web server is correctly configured.

## Contributors

- [Premnath ](https://github.com/premnath018) - Creator and Maintainer

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
