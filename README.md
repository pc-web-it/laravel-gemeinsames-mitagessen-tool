<a id="readme-top"></a>


<!-- PROJECT LOGO -->

<br  />

<div  align="center">

<a  href="https://www.pc-web.at/">

<img  src="https://pc-web.space.pc-web.cloud/images/News-Fotos/_1200x630_crop_center-center_82_none_ns/pc-web.jpg?v=1713349612"  alt="Logo"  width="300"  height="200">

</a>

  

<h3  align="center">Gemeinsames Mittagessen Tool</h3>

  

<p  align="center">

<br />

<a href="https://www.pc-web.at/"><strong>See our website »</strong></a>

<br />

<br />

</p>

</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
      <li><a href="#key-features">Key Features</a></li>
      <li><a href="#how-it-works">How It Works</a></li>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#developers">Developers</a></li>
    <li><a href="#contact">Contact</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

[![Product Name Screen Shot][product-screenshot]](https://example.com)

### Gemeinsames Mittagessen Tool

The "Gemeinsames Mittagessen Tool" is designed to facilitate the organization of monthly lunch meetings within a company. The main feature of the project is to randomly select two employees from a stored list: one employee to cook and another to present at the monthly meeting. This helps in engaging employees and promoting teamwork and interaction.

### Key Features

1. **Employee Selection for Monthly Meetings**:
   - Randomly selects one employee to cook and another to present at the monthly lunch meeting from the list of employees.

2. **Lucky Wheel**:
   - A fun "lucky wheel" feature allows for selecting "x" number of winners from a list of names imported in .csv format. This can be used for various purposes such as raffles, prize distributions, or any other random selection needs.

3. **Recipe Management**:
   - Maintains a list of recipes associated with each monthly meeting. This feature allows employees to view and share recipes, fostering a culture of sharing and collaboration.

### How It Works

- **Employee Selection**:
  - The tool ensures that the same employee is not chosen for both cooking and presenting unless there are insufficient employees available. It also handles cases where there are not enough employees to make a selection by providing appropriate feedback.

- **Lucky Wheel**:
  - Users can import a list of names from a .csv file and use the "lucky wheel" to randomly select winners. This adds an element of excitement and fun to the process of random selection.

- **Recipe Listing**:
  - Recipes can be added, viewed, and managed for each meeting. This helps in documenting and sharing culinary ideas among employees.

The "Gemeinsames Mittagessen Tool" aims to enhance employee interaction and engagement through organized and enjoyable monthly meetings, while also providing additional features that can be used for various other purposes within the organization.

<p align="right">(<a href="#readme-top">back to top</a>)</p>



### Built With

The frameworks used in this proyect are:

* [![Tailwind][Tailwind.com]][Tailwind-url]
* [![Laravel][Laravel.com]][Laravel-url]


<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- GETTING STARTED -->
## Getting Started

To start using this project you will need to do the following:

### Prerequisites

Before you begin, ensure you have met the following requirements:

- **Docker**: Docker is used to containerize the application. You need to have Docker installed on your machine.
  - [Docker Installation Guide](https://docs.docker.com/get-docker/)

- **Docker Compose**: Docker Compose is used to manage multi-container Docker applications.
  - [Docker Compose Installation Guide](https://docs.docker.com/compose/install/)

- **PHP**: PHP is required for Laravel development and for running artisan commands locally (if needed).
  - [PHP Installation Guide](https://www.php.net/manual/en/install.php)

- **Laravel**: Laravel framework is used for building the application.
  - You can use Composer to install Laravel dependencies once you have PHP and Composer installed.
  - [Composer Installation Guide](https://getcomposer.org/doc/00-intro.md)

Ensure these prerequisites are met before setting up and running the project.

### Installation

_Once you have the prerequisites installed you will have to do the following:_

1. Clone the repo
   ```sh
   git clone https://github.com/pc-web-it/laravel-gemeinsames-mitagessen-tool.git
   ```

   And go to laravel-gemeinsames-mitagessen-tool
    ```sh
   cd laravel-gemeinsames-mitagessen-tool
   ```

2. Enter in `.env.example`:
  Configurate the connection to your database
   ```sh
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
   ```

   Then add the initial password to log in in the proyect:
   ```sh
    INITIAL_ADMIN_PASSWORD=password
   ```
3. Go to the terminal and copy the `.env.example` into `.env`
   ```sh
   cp .env.example .env
   ```

4. Start the docker
    ```sh
        start
    ```

5. Enter to the docker shell
    ```sh
        shell app
    ```
6. Install all the required packages
    ```sh
        composer install
    ```

7. Finally generate the key
    ```sh
        php artisan key:generate
    ```

Your project should be running into localhost:8080.

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- USAGE EXAMPLES -->
## Usage

_To know how to usage of the project, please refer to the [Documentation](https://example.com)_

<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- DEVELOPERS -->
## Developers

- **Viktoria Dudina**: [LinkedIn](https://www.linkedin.com/in/viktoria-dudina-56597429a) | [GitHub](https://github.com/ViktoriaDudina)
- **Juan Antonio Aragón**: [LinkedIn](https://www.linkedin.com/in/23juanan) | [GitHub](https://github.com/juanan04)

<!-- CONTACT -->
## Contact

Pc-Web - [@pc_web_it](https://www.instagram.com/pc_web_it/) - support@pc-web.at

Project Link: [https://github.com/pc-web-it/laravel-gemeinsames-mitagessen-tool](https://github.com/pc-web-it/laravel-gemeinsames-mitagessen-tool)

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[product-screenshot]: images/screenshot.png
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Tailwind.com]: https://img.shields.io/badge/Tailwind-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white
[Tailwind-url]: https://tailwindcss.com/
