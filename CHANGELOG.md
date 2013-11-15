###Flint 1.1.0
For complete diff, check out [Pull Request](https://github.com/starverte/flint/pull/109)
- Added templates: Clear, Minimal, Wide, Full, Narrow, Slim
- Added customizer support: change fonts, colors, and more
- Added theme options
 - Custom Footer
 - Featured Images: Show or hide on posts and pages
 - Default page template: Content width, Footer widget area width
 - Clear: Navigation, content width
 - Minimal: Navigation, content width, widget area


###Flint 1.0.5 - October 3, 2013
- Update branding
- Add bottom margin to articles

###Flint 1.0.4 - October 3, 2013
- Add `get_sidebar()` to `front-page.php` to display sidebar on front page
- Change sidebar display name from "Sidebar" to "Footer" for clarity
- Change sidebar functional name from `sidebar-1` to `footer` for clarity

###Flint 1.0.3 - September 23, 2013
- Removed `.hentry { margin: 0 0 6em; }`
- Added spacing and top border to `#comments`

###Flint 1.0.2 - August 27, 2013
- Renamed "font" directory to "fonts" so glyphicon font can work (fixes [#103](https://github.com/starverte/flint/issues/103))
- Fixed footer for small screens (fixes [#101](https://github.com/starverte/flint/issues/101))
- Updated editor-style.css (fixes [#98](https://github.com/starverte/flint/issues/98))

###Flint 1.0.1 - August 24, 2013
- Shipped with Bootstrap 3
- Changed `is_single()` to `is_singular()` for `type-page.php` and `type.php`
- Sidebar no longer shows up if there are not any widgets
- `h1.entry-title` is now slightly larger than `h1`

###Flint 1.0.0 - August 24, 2013
- Shipped with Bootstrap 3 (stable)
- Removed Font Awesome files (weren't used)
- Updated template structure (see issue [#91](https://github.com/starverte/flint/issues/91))

###Flint 0.14.0 - August 18, 2013
- Initial release
- Shipped with Bootstrap 3 RC 2 and Font Awesome 3.2.1
