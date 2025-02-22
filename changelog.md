# Change log

## [3.0.2] - 2022-05-11

### Added

- Mail settings section in the docker readme by [@aronmal](https://github.com/aronmal)

### Fixed

- [issue #72](https://github.com/Bubka/2FAuth/issues/72) 2FA secret passed as plain text rejected by form validation
- [issue #73](https://github.com/Bubka/2FAuth/issues/73) CSRF token mismatch
- [issue #78](https://github.com/Bubka/2FAuth/issues/78) Add tags other then latest when pushing images to dockerhub

## [3.0.1] - 2022-05-11

### Fixed

- [issue #68](https://github.com/Bubka/2FAuth/issues/68) 2fauth not run after update
- [issue #71](https://github.com/Bubka/2FAuth/issues/71) Cannot view old TOTP entries on latest Docker Image
- Missing login information on the demo website

## [3.0.0] - 2022-05-09

Finally, here is version 3.0!

This is a milestone in the 2FAuth development that greatly enhances 2FAuth under the hoods and comes with a [brand new documentation](https://docs.2fauth.app/).

### New

- 2FAuth now exposes a REST API following the OpenAPI 3.1 specification that allows connexion with third parties (see the [API doc](https://docs.2fauth.app/api/))
- Support of the _Web Authentication_ standard, aka WebAuthn, to login using a security device like a Yubikey or FaceID
- Support of authentication proxy to bypass the 2FAuth auth login
- Heroku setup to deploy 2FAuth using the _Deploy to Heroku_ button

#### Also added

- Ability to delete the user account and reset 2FAuth
- The content of any non-2FA QR code can be copied or followed (in case of an HTTP link)
- PHP 8.0 support

### Changed

- 2Fauth now uses the browser language preference by default.
- The current group is now clickable in the group selector
- Upgrade to Laravel 8

### Fixed

- [issue #45](https://github.com/Bubka/2FAuth/issues/45) Account or Service field containing colon breaks the Test feature in the advanced form
- [issue #47](https://github.com/Bubka/2FAuth/issues/47) Account creation fails when otpauth service parameter is missing
- [issue #50](https://github.com/Bubka/2FAuth/issues/50) Email password reset does not work
- [issue #51](https://github.com/Bubka/2FAuth/issues/51) Cannot delete a group with accounts (MySQL only)
- [issue #52](https://github.com/Bubka/2FAuth/issues/52) null "Default group" setting after group delete
- [issue #57](https://github.com/Bubka/2FAuth/issues/57) Can't save icons or upload QR codes - Docker installation

### Removed

- PHP 7.3 support

## [2.1.0] - 2021-03-04

### Added

- German translation, thanks to [@chenmichael](https://crowdin.com/profile/chenmichael)

## [2.0.2] - 2020-12-04

### Fixed

- [issue #20](https://github.com/Bubka/2FAuth/issues/20) Issues using 'Protect sensible data'

## [2.0.1] - 2020-12-03

### Fixed

- [issue #18](https://github.com/Bubka/2FAuth/issues/18) Install using MySQL causes exception
- [issue #17](https://github.com/Bubka/2FAuth/issues/17) Capitalization of email address during login should not matter
- [issue #15](https://github.com/Bubka/2FAuth/issues/15) Applied group filter is not removed if the group is deleted
- [issue #14](https://github.com/Bubka/2FAuth/issues/14) Cache is not refreshed automatically after group changes
- Missing footer links at first start
- Missing redirection after registration

## [2.0.0] - 2020-11-29

2FAuth goes to v2.0!

This release comes with multiple improvements and a lot of changes under the hood.
Don't forget to backup your database before you upgrade. Have fun :)

### Added

- Add Groups to enhance accounts management
- New advanced form to define fully customized accounts without QR code
- New user option to skip the submitting page
- New DB protection option to encrypt sensitive 2FA data
- QR code generation of recorded accounts
- Support of the OTP `image` parameter when a QR code is imported

### Changed

- Performance improvement thanks to data caching
- Show Register/Login forms and their links only when relevant
- Let the user choose between all available submitting methods (livescan, qrcode upload, advanced form)
- Translations are now managed on [Crowdin.com/2fauth](https://crowdin.com/project/2fauth). You master some foreign languages? Why not help translate 2FAuth, your help would be welcome.

### Fixed

- [issue #13](https://github.com/Bubka/2FAuth/issues/13) Long Service name push content out of viewport
- [issue #11](https://github.com/Bubka/2FAuth/issues/11) Token generation do not loop if TOTP period is different from 30s
- [issue #9](https://github.com/Bubka/2FAuth/issues/9) Upload QR code in standard form return a 422 missing uri field

## [1.3.1] - 2020-10-12

### Changed

- Upgrade to Laravel 7.0
- Drop PHP 7.2 support
- Enable the Request reset password form in Demo mode but inactivated

### Fixed

- Fix missing notifications in Auth views

## [1.3.0] - 2020-10-09

### Added

- Application lock on security code copy or after a fixed period of inactivity
- Notify user that https is required in order to use camera streaming to flash QR code
- Notify user that the security code has been copied to clipboard when user click it
- Show selected accounts count in Manage view
- New option to show/hide icons in accounts list

### Changed

- More mobile friendly Close button for modal
- More advanced notification component
- Fixed header to keep Search field and Delete button always visible
- Switches replaced by checkboxes in Settings

### Fixed

- Hide context around iPhone X+ notch
- Unwanted access to restricted pages as guest

## [1.2.0] - 2020-09-18

### Added

- QR Code scan using live stream when a camera is detected. Previous QR Code scanner remains available as fallback method or can be forced in Settings.
- New alternative layouts: List or Grid
- Accounts can be reordered

### Changed

- Notification banner (when saving settings) now has a fixed position

## [1.1.0] - 2020-03-23

### Added

- Demonstration mode with restricted features and ability to reset content with an artisan command
- Option to close token popup when the code is pasted (by clicking/taping on it)

### Changed

- Options default values can now be set in config/app
- Generated assets are now part of the repo to ease deployement

### Fixed

- Option labels attached to wrong checkboxes
