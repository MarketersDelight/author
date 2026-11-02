<style type="text/css">

/*------------------------------*\
	$AUTHOR EXTRAS
\*------------------------------*/

/* AUTHOR BOX */

.author-meta {
	align-items: center;
	display: flex;
	margin-block-end: var(--md-half);
}

.author-title {
	font-size: var(--md-h4);
	font-weight: var(--md-bold);
	line-height: var(--md-h4-line-height);
	margin-block-end: var(--md-small);
}

.author-description { margin-block-end: calc(var(--md-half) + var(--md-small)); }

.author-avatar {
	flex: 0 1 var(--md-double);
	margin-inline-end: var(--md-half);
}

.author-avatar img { width: 100%; }

.author-links {
	align-items: center;
	display: flex;
	font-size: var(--md-font-size-small);
	gap: var(--md-half);
	line-height: var(--md-line-height-small);
}

.author-links .author-link {
	display: flex;
	gap: var(--md-third);
}

.author-links .author-link:not(:last-child) { margin-inline-end: var(--md-small); }

.author-link.twitter .circle-icon {
	background-color: #000;
	color: var(--md-site-text-contrast);
}

.author-link.twitter .md-icon-twitter { color: var(--md-site-text-contrast); }

.author-link.twitter a { color: #1da1f2; }

@media all and (max-width: 700px) {
	.author-links { flex-flow: wrap; }
	.author-links .author-link { flex-basis: calc(50% - var(--md-half)); }
}
