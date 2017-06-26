Signer
=======================
A hellosign.com coding exercise, completed by Mlibazisi Prince Mabandla

### Requirements

This tool requires:
- PHP version 5.5 or higher
- Composer ([https://getcomposer.org/doc/00-intro.md](https://getcomposer.org/doc/00-intro.md))

### Installation

- Download the signer package

- Navigate to the root directory of the signer package and run composer install

    ```shell
    composer install
    ```

- Navigate to the `/bin dir` and make sure that `sign.php` is executable

    ```shell
    chmod +x sign.php
    ```

### Configuration

- Its not necessary to edit `/config/config.php`, but you are free to do so

- Navigate to `/config` and create a `parameters.ini` file

    ```shell
    touch parameters.ini
    ```

- Open `parameters.ini` and add the following line and replace the value with your API KEY:

    ```shell
    api_key = "REPLACE_WITH_YOUR_API_KEY"
    ```

### Usage

- Navigate to the `/bin` directory, and execute the `sign.php` file.

    ```shell
    php sign.php [name of signer] [email of signer] [full_file_path to file you want to sign]
    ```