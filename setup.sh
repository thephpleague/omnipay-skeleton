#!/bin/sh

# One per line
FILES_TO_ALTER='README.md
composer.json
LICENSE
CONTRIBUTING.md
CHANGELOG.md';

printf "\nVendor (lowercase):\n> ";
read vendor;

printf "\nGateway (PascalCase):\n> ";
read gateway;

printf "\nAuthor name:\n> ";
read author_name;

printf "\nAuthor website (include https://):\n> ";
read author_website;

printf "\nAuthor email:\n> ";
read author_email;

printf "\nPackage source URL (include https://):\n> ";
read package_source_url;

printf "\nPackage contributions URL (e.g. pull/merge requests, include https://):\n> ";
read package_contributions_url;

printf "\nPackage support URL (e.g. issues/tickets, include https://):\n> ";
read package_support_url;

# Don't ask for it, but clearly you can write something else here
package_description="$gateway driver for the Omnipay PHP payment processing library";
year=$(date '+%Y');

# DRY helpers
alias lower='tr [:upper:] [:lower:]';
alias addslashes='sed -e "s/\//\\\\\//g"';

# Do the magic
printf "\nReplacing :text in files...\n"
for f in $FILES_TO_ALTER; do
  sed -e "s/:vendor/$(echo $vendor | lower)/g
          s/:gateway/$(echo $gateway | lower)/g
          s/:Gateway/$gateway/
          s/:author_name/$author_name/
          s/:author_email/$author_email/
          s/:author_website/$(echo $author_website | addslashes)/
          s/:year/$year/
          s/:package_description/$package_description/
          s/:package_source_url/$(echo $package_source_url | addslashes)/
          s/:package_contributions_url/$(echo $package_contributions_url | addslashes)/
          s/:package_support_url/$(echo $package_support_url | addslashes)/" $f > $f.new
  mv $f.new $f
done

printf "\nReplacing Skeleton by $gateway in class names...\n"
for f in $(find -name '*.php' && echo './composer.json'); do
  sed -e "s/Skeleton/$gateway/g" $f > $f.new
  mv $f.new $f
done
mv ./src/SkeletonGateway.php "./src/${gateway}Gateway.php"

# Initialize a new git repo
printf "\nDeleting git repo...\n\n"
rm -rf .git
git init

# All done, nothing else for me to do here, so... Harakiri x.X good bye!
printf "\nDeleting skeleton help texts and setup file...\n"
sed -e '/Replace/,/your description/ { d }' README.md > README.md.new
mv README.md.new README.md
rm setup.sh

printf "\nAll done! You're ready to write your payment driver :)\n"
