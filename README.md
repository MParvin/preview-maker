### The Package

[![Latest Stable Version](https://poser.pugx.org/phpunit/phpunit/v)](//packagist.org/packages/phpunit/phpunit) [![Total Downloads](https://poser.pugx.org/phpunit/phpunit/downloads)](//packagist.org/packages/phpunit/phpunit) [![Latest Unstable Version](https://poser.pugx.org/phpunit/phpunit/v/unstable)](//packagist.org/packages/phpunit/phpunit) [![License](https://poser.pugx.org/phpunit/phpunit/license)](//packagist.org/packages/phpunit/phpunit)

### Overview

PreviewMaker is a standalone application written in pure PHP to create preview (PDF and image) from different file formats ranging from Microsoft documents to video formats.

### Requirements

You need to have a **Linux OS** with the following items installed:

- PHP v7.2.5 above
- OpenJDK
- LibreOffice v6.2.6.2 above

### Installation

```bash
$ composer require hamidgh83/preview-maker
```
> **Note:** We are preparing a docker version for easier deployment.

### Supported Files

PreviewMaker makes it easy to create image preview from Microsoft documents, PDF files and videos. Here is the list of supported *mime types*:

**Documents**
- "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
- "application/vnd.ms-excel",
- "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
- "application/vnd.ms-powerpoint",
-"application/vnd.openxmlformats-officedocument.presentationml.presentation",
- "application/vnd.oasis.opendocument.text"

**PDF**
- "application/pdf"

**Videos**
- "video/3gpp",
- "video/mp4",
- "video/mpeg",
- "video/ogg",
- "video/quicktime",
- "video/webm",
- "video/x-m4v",
- "video/ms-asf",
- "video/x-ms-asf",
- "video/x-ms-wmv",
- "video/x-msvideo"

### Console commands

**Creating preview from a file**

***Usage***

    php bin/console.php preview [options] [--] <filepath>

***Arguments***
| Argument | Description |
| ------------- |:-------------:|
|filepath | Path to the file you want to make preview from |

***Options***
| Option | Description |
| ------------- |:-------------|
| -o, --output=OUTPUT | Path to output file |
| -h, --help | Display this help message |
| -q, --quiet | Do not output any message |
| -V, --version | Display this application version |
| --ansi | Force ANSI output |
| --no-ansi | Disable ANSI output |
|  -n, --no-interaction | Do not ask any interactive question |
|  -v|vv|vvv, --verbose | Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug |
