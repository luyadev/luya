Concept
=======

Frontend User Module

+ Groups can be created trough Admin Module
+ ActiveRecord interface for `getGroups()`.
+ Provide user class where users can make a login `frontenduseradmin\User::login(AR)`
+ Provide user class methods the check whetver a group is in the users group list.
+ Create ActionFilter where the callback matches the getGroups.
+ Create global events (file manager, display cms page, show/hidde menu links)