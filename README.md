# DRY Templating for GeoCore

by Evan Boyd Sosenko.

__This addon should be considered beta and is still lacking complete documentation.__

## Installation

Place the contents of this addon into `addons/dry_templating` under the root of your [GeoCore](https://geodesicsolutions.com/geocore-software.html) install.
Then, install and enable the addon.

## Usage

This addon allows you to create as many tags as you like for inclusion into your templates.
Each tag will insert the contents of the template with the name given by the `name` parameter.

The real power of this addon comes from the ability to define page groups to dynamically control the content in each template.

### Example case

How to use this addon is best done with an explicit example.

Suppose you want the description meta tag on every page to be the same,
expect on the listing page where it should be the description of the listing.

## Development

The [addon source](https://github.com/razor-x/geocore-dry_templating) is hosted at github.
To clone the project run

````bash
$ git clone https://github.com/razor-x/geocore-dry_templating.git
````

## License

This addon is licensed under the MIT license.

## Warranty

This software is provided "as is" and without any express or
implied warranties, including, without limitation, the implied
warranties of merchantibility and fitness for a particular
purpose.
