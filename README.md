# Author Extras

A [Marketers Delight](https://marketersdelight.com/) drop-in for your authors. Each author can upload a photo that replaces their Gravatar across the site, show it beside single post titles, and add a job title, social profiles and their own links to the theme's author box.

## Features

- **Author photo**: an upload on each user's profile
  - Used as the author's avatar in bylines, the theme's author box and comments, so it shows without a request to Gravatar
  - Shown as the image on the author's archive page, in place of the sitewide author image
- **Author photo in titles**: the author's photo beside single post titles, for any post type
  - A featured image placed beside the title keeps its place, and authors without a photo show none
- **Job title**: shown under the author's name in the author box
- **Social profiles**: X, YouTube, Instagram, LinkedIn, Facebook, Pinterest, TikTok, Bluesky, Substack, Telegram and GitHub, listed in the author box with icons and names
  - Saved to the same user meta keys SEO plugins use, so the values carry over either way, and a network another plugin already shows a field for is left out
- **Other links**: up to 3 of the author's own links (a book, a course, another site), shown beside their website

## Settings

**On each user's profile**: **Author photo**, and the **Author Extras** box: **Job title**, **Social profiles** and **Other links**. Authors can fill these in on their own profile.

**On each post type's MD settings page**:

- **Page Title → Author Photo**: show the author's photo beside single post titles, with its **Position**, **Position on mobile** and **Max width**

**On each post**, in MD's Layout options: **Remove Author photo** when the post type shows one.

## Developers

- `md_author_photo_id( $user_id )`: an author's uploaded photo as an attachment ID, or `0`. Gravatar is never used.
- Author Extras fills the theme's `md_media` and `md_title_media` filters for the author page image and the title photo, and swaps avatars on `pre_get_avatar_data`.
- It fills the theme's author box through `md_author_box_subtitle` (job title) and `md_author_box_links` (social profiles, and other links marked `custom`).

## Requirements

Author photos shipped inside the MD theme until they moved to this drop-in in MD 6.1.1. Saved photos and settings carry over as they are.

- Marketers Delight 6.2.4 or later
- WordPress 6.2 or later
- PHP 7.4 or later

## Install

1. Download the latest `author-x.y.zip` from the [Releases page](https://github.com/MarketersDelight/author/releases).
2. In WordPress, go to MD's Drop-ins screen, click **Add new**, and upload the zip.
3. Activate Author Extras, then upload your photo on your **Profile**.

Don't use **Code → Download ZIP**. That zip includes development files and a folder name that MD won't recognize.

## License

GPL-2.0-or-later. See [LICENSE](LICENSE).
