# Author Extras

A [Marketers Delight](https://marketersdelight.com/) drop-in for your authors. Each author can upload a photo that replaces their Gravatar across the site, posts can end with an author box, and the author's photo can sit beside single post titles.

## Features

- **Author photo**: an upload on each user's profile
  - Used as the author's avatar in bylines, the author box and comments, so it shows without a request to Gravatar
  - Shown as the image on the author's archive page, in place of the sitewide author image
- **Author box**: the author's photo, name, bio and links after a post's content
  - Links to the author's website, X profile and archive when they're set
- **Author photo in titles**: the author's photo beside single post titles, for any post type
  - A featured image placed beside the title keeps its place, and authors without a photo show none
- Styles are added to MD's compiled stylesheet

## Settings

**On each user's profile**: **Author photo**.

**On each post type's MD settings page**:

- **Layout → Add Author Box**: show the author box after every post of this type
- **Page Title → Author Photo**: show the author's photo beside single post titles, with its **Position**, **Position on mobile** and **Max width**

**On each post**, in MD's Layout options: **Add Author Box** or **Remove Author Box** against the post type's setting, and **Remove Author photo** when the post type shows one.

## Developers

- `md_author_photo_id( $user_id )`: an author's uploaded photo as an attachment ID, or `0`. Gravatar is never used.
- `md_has_author_box()` and `md_author_box()`: check for and print the author box on the current post.
- Override the author box markup by copying `templates/author-box.php` to `templates/author/author-box.php` in your child theme.
- Author Extras fills the theme's `md_media` and `md_title_media` filters for the author page image and the title photo, and swaps avatars on `pre_get_avatar_data`.
- Markup uses `.author-box`, `.author-meta`, `.author-avatar`, `.author-description` and `.author-links` classes.

## Requirements

Author photos and the author box shipped inside the MD theme until they moved to this drop-in in MD 6.1.1. Saved photos and settings carry over as they are.

- Marketers Delight 6.1.1 or later
- WordPress 6.2 or later
- PHP 7.4 or later

## Install

1. Download the latest `author-x.y.zip` from the [Releases page](https://github.com/MarketersDelight/author/releases).
2. In WordPress, go to MD's Drop-ins screen, click **Add new**, and upload the zip.
3. Activate Author Extras, then upload your photo on your **Profile**.

Don't use **Code → Download ZIP**. That zip includes development files and a folder name that MD won't recognize.

## License

GPL-2.0-or-later. See [LICENSE](LICENSE).
