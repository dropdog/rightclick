core = 8.x
api = 2

; include the D.O. profile base
includes[core] = drupal-org-core.make

; Profile
projects[rightclick][type] = profile
projects[rightclick][download][type] = git
projects[rightclick][download][url] = git@github.com:dropdog/rightclick.git
projects[rightclick][download][branch] = develop

; Alternative branches to test
;projects[rightclick][download][branch] = master
;projects[rightclick][download][branch] = [release_tag]
