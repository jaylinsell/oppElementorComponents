
These components are developed to be used with the Elementor wordpress plugin.

This project utilises parcel.js to compile the javascript and css.

The css and js is compiled into the parent level of the theme.
When uploading contents of the build, be sure to add the root level css and js files rather than ones located in this directory.

## Cloning the repo
You will need to clone this repo into the child theme of the site, and you should end up with the following:

**/wp-content/themes/child/opp-components**

This is to ensure when updates are made and committed, the files are solely related to the updated components, regardless of the theme.

The css, js and OPP component registration also needs to be manually added to the functions.php of the child theme if it hasn't already been done.

## Requirements
Installation of Node.js and either NPM, Yarn or PNPM

*If using yarn or pnpm, it's just yarn {{ command }} or pnpm {{ command }}.
If using npm, other than npm install, be sure to use npm run {{ command }}*

For the first time running, run

```
pnpm install
```

## Running the dev environment
```
pnpm dev
```

## Compiling for production
```
pnpm build
```

## Go Live Checklist
The following files need to be deployed after pnpm build:
 Current Direcotry (uploaded to /{{child-theme}}/opp-components:
 - **All and only the .php files**

 Parent Directory (Files will be compbiled here) uploaded to /{{child-theme}} :
 - **js folder**
 - **scss folder**
 - **home.{{has}}.svg** - check CLI log for hash vesrion.



