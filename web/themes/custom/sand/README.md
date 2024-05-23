```

  ___________          .__          __                 
 /   _____/  | __ ____ |  |   _____/  |_  ____   ____  
 \_____  \|  |/ // __ \|  | _/ __ \   __\/  _ \ /    \ 
 /        \    <\  ___/|  |_\  ___/|  | (  <_> )   |  \
/_______  /__|_ \\___  >____/\___  >__|  \____/|___|  /
        \/     \/    \/          \/                 \/ 

```
# Skeleton Theme for Drupal 8

Skeleton is a Drupal 8 theme that leverages Paladin and the inverted triangle CSS concept and atomic design for a super-lightweight and componentized experience. The structure of the SASS is largely inspired by Lindsay Grizzard's article on creating CSS systems: https://medium.com/gusto-design/creating-the-perfect-css-system-fa38f5bcdd9e.

Use this theme as a basis for custom client themes.  Make sure to change the Skeleton name in the following places:
The theme folder name
composer.json
package-lock.json
package.json
readme.md
skeleton.info.yml
skeleton.libraries.yml
skeleton.theme

*You can also remove the skeletonhelper.png and the line in the info.yml file.*
*A great idea would be to include a png of the client's logo and change the screenshot line in the info.yml file.*

## Installation

Before using Skeleton, you need to run `npm install` in the root of the theme directory (usually /docroot/themes/custom/skeleton) to ensure all appropriate node packages are loaded.

## Compiling SASS

If you don't feel like reading the thrilling contents of the gulpfile.js, you can run `gulp styles` to compile CSS to SASS or `gulp watch` to watch for changes in the sass directory.

## SASS Structure and ITCSS

Inverted triangle CSS is structured in order of least to most specificity. The SASS directory in Skeleton is structured as follows:

* 0-vendor: Vendor-specific styles. So far we have none of these but this is a living document! We may kill this. Who knows! Exciting times in theme development.
* 1-settings-tools: Colors, fonts, other globals.
* 2-generic: resets
* 3-atoms: the building blocks/bare HTML elements (p, h1, img) and smaller bits that make up the larger ones
* 4-molecules: groups of atoms that work together (menus, utilities)
* 5-organisms: larger groups of molecules (header, footer, views).
* 6-helpers: the most specific classes for columns, color classes, alignment, and shapes.

All of the folders contain SCSS partials that are imported into a main SCSS file, with the exception of organisms (which has some individual SASS files, more on this below). Then the SCSS files are compiled into a single CSS directory with their associated sourcemaps. These files can be referenced in libraries.

### The organisms directory

Everything in the organisms directory that should be globally applied follows the same structure of a SCSS partial being imported into the global-components.scss file. The difference here is that there are certain organisms that do not need to be applied globally. For example, an accordion library can be attached to an accordion template and used only when needed. Therefore, these files exist as standalone, non-partial SCSS files that can be referenced in their own libraries for efficient attachment.