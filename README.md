ocean90/wp-cli-cron-fixer
=========================

Remove broken entries from the cron array.

## Using

```
wp cron event fixer [--dry-run]
```

**OPTIONS**

	[--dry-run]
		Run the fix and show report, but don't fix the broken cron.


## Example

```bash
for SITE in $(wp site list --field=url); do \
  echo "$SITE"; \
  wp cron event fixer --url=$SITE; \
done
```

## Installing

Installing this package requires WP-CLI v0.23.0 or greater. Update to the latest stable release with `wp cli update`.

Once you've done so, you can install this package with `wp package install ocean90/wp-cli-cron-fixer`.
