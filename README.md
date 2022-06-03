# Car-Sharing
Car sharing - school project

![look1](img/look1.png)

![look2](img/look2.png)

### Test it now 
**👉 http://msior.ct8.pl/Car-Sharing/ 👈** (without events and triggers)


## Installation

 - Clone/download the repository
 - Prepare the database (.sql file in directory `\Database`)
 - In `\Project`:
   - In terminal run `npm i` to install dependencies
   - In the terminal run `npm run build` to build project
   - Run `\public\index.html` with php server (e.g. XAMPP)
    

## Features

- Login/Registration
- Account types (Client/Mod/Admin)
- Car Reservation
- User management
- Simulation of time lapse
- Pseudo qr code of a reservation in progress


## Technologies

<p>
 <img src="https://img.shields.io/badge/Svelte-FF3E00?logo=Svelte&logoColor=white&style=for-the-badge" /> 
 <img src="https://img.shields.io/badge/JavaScript-F7DF1E?logo=JavaScript&logoColor=black&style=for-the-badge" /> 
 <img src="https://img.shields.io/badge/HTML5-E34F26?logo=HTML5&logoColor=white&style=for-the-badge" /> 
 <img src="https://img.shields.io/badge/CSS3-1572B6?logo=CSS3&logoColor=white&style=for-the-badge" /> 
 <img src="https://img.shields.io/badge/Tailwind CSS-06B6D4?logo=Tailwind CSS&logoColor=white&style=for-the-badge" /> 
</p>
<p>
 <img src="https://img.shields.io/badge/PHP-777BB4?logo=PHP&logoColor=white&style=for-the-badge" /> 
 <img src="https://img.shields.io/badge/MySQL-4479A1?logo=MySQL&logoColor=white&style=for-the-badge" />
</p>

## Accounts rights

### Client:
- car reservation
- browsing available cars
- managing own reservations
- access to qr code
- possibility to return the car

### Mod:
- client rights
- management of all reservations

### Admin:
- client and mod rights
- user management
- access to time simulation
