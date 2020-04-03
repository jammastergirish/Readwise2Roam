# Readwise2Roam

Readwise to Roam brings together two of my favorite products:
  - [Readwise](https://readwise.io) which syncs with Amazon Kindle, Apple Books, Instapaper and many others to bring your highlights into its database and email you a selection every morning.
  - [Roam Research](http://roamresearch.com) which is a note-taking app that allows all notes to be relative to each other, thanks to its "bi-directional linking."
  
As soon as I started using Roam, I wanted to bring my Readwise highlights into it but, with more than 5,000 of them, I wasn't going to do that manually. So I wrote a PHP script to convert Readwise's exported CSV file to Roam's importable MD files.

## To use

Download/clone `readwise2roam.php` to a new directory (which will eventually be filled with MD files so you don't want this on your desktop!).

Go to Readwise and click on `Account Settings` then `Export Your Data` and download the CSV file to the same new directory.

On Mac, go to Terminal and `cd` to the new directory (either by knowing the full path or by simply typing `cd ` (with a followup space) and then dragging the new directory into Terminal) and then type `php readwise2roam.php`.

The script should run and fill the directory with MD files, the names of which will correspond to the titles of the books/articles you highlighted in Readwise.

Go to Roam Research and click the three dots on the top right then `Import Files`. Select however many of the files you would like to import. Feel free to change the "New Page Name" then hit Import!

That's it!

## Issues

If you do this more than once (without having carefully curated what you're bringing in to Roam), you'll end up with pages containing repeated highlights. It's obviously up to you to curate your list.

Roam's import function doesn't seem to work well in Safari. Try Firefox.
