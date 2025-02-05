# Makefile for automatically making thumbnail images.
#
# Official targets:
#   all (default target)
#   clean
#   info (echoes some info, nothing is really done)

# ALL_ORIGINAL is a space-separated list of original images.
ALL_ORIGINAL:=$(wildcard original_size/*.png) $(wildcard original_size/*.jpg)

# other ALL_XXX are a space-separated list of target images.
ALL_THUMB:=$(subst original_size,thumb_size,$(ALL_ORIGINAL))
ALL_THUMB_CONST_HEIGHT:=$(subst original_size,thumb_const_height_size,$(ALL_ORIGINAL))
ALL_TEASER:=$(subst original_size,teaser_size,$(ALL_ORIGINAL))
ALL_GALLERY:=$(subst original_size,gallery_size,$(ALL_ORIGINAL)) \
  gallery_size/ui-shaker.gif gallery_size/typing-label.gif

ALL_OS_ICONS_ORIGINAL_SIZE:=$(wildcard os_icons_original_size/*.png)
ALL_OS_ICONS:=$(subst _original_size,,$(ALL_OS_ICONS_ORIGINAL_SIZE))

.PHONY: all clean info

ALL_TARGETS := $(ALL_TEASER) \
  $(ALL_THUMB) \
  $(ALL_THUMB_CONST_HEIGHT) \
  $(ALL_GALLERY) \
  $(ALL_OS_ICONS) \
  castle_game_engine_icon.png

# On Cygwin, change it to /usr/bin/convert
CONVERT := convert

all: $(ALL_TARGETS)

# making teaser_size ---------------------------------------------------------

# see http://www.imagemagick.org/Usage/thumbnails/#cut
# http://www.imagemagick.org/discourse-server/viewtopic.php?t=21324
teaser_size/%: original_size/%
	$(CONVERT) $< -thumbnail 600x300^ -gravity North -extent 600x300 $@

# ----------------------------------------------------------------------------
# making thumb_size

thumb_size/glplotter%: original_size/glplotter%
	$(CONVERT) $< -emboss 5.0 -geometry 200x $@

thumb_size/%: original_size/%
	$(CONVERT) $< -geometry 200x $@

# ----------------------------------------------------------------------------
# making thumb_const_height_size

thumb_const_height_size/glplotter%: original_size/glplotter%
	$(CONVERT) $< -emboss 5.0 -geometry x200 $@

thumb_const_height_size/%: original_size/%
	$(CONVERT) $< -geometry x200 $@

# ----------------------------------------------------------------------------
# making gallery_size

# glplotter screns require scaling with emboss,
# otherwise look just black.
gallery_size/glplotter%.png: original_size/glplotter%.png
	$(CONVERT) $< -emboss 15.0 -geometry 300x300 $@

gallery_size/%: original_size/%
	$(CONVERT) $< -geometry 300x300 $@

# ----------------------------------------------------------------------------
# making main_link_size

main_link_size/%: original_size/%
	$(CONVERT) $< -geometry 256x256 $@

# engine icon processing -----------------------------------------------------

castle_game_engine_icon.png: ../../../castle-engine/doc/pasdoc/logo/castle_game_engine_icon.png
	cp -f $< $@

# OS icons -------------------------------------------------------------------

os_icons/%.png: os_icons_original_size/%.png
	$(CONVERT) $< -geometry 64x64 $@

# gifs -----------------------------------------------------------------------

# 1082 × 598
# 300 x 598*300/1082=166
gallery_size/typing-label.gif: original_size/typing-label.mp4
	ffmpeg -y -i $< -vf scale=300:166 $@

# 1096 × 616
# 300 x 616*300/1096=167
gallery_size/ui-shaker.gif: original_size/ui-shaker.mp4
	ffmpeg -y -i $< -vf scale=300:167 $@

# others ---------------------------------------------------------------------

clean:
	rm -f $(ALL_TARGETS)

info:
	@echo 'All original images:'
	@echo '  ' $(ALL_ORIGINAL)
	@echo 'All targets:'
	@echo '  ' $(ALL_TARGETS)
