sobafire.com-Sources
====================

> Sobafire is an old, untested project which I coded just for educational purposes. Development started during 2011 and ended early 2012. It doesn't support features like coding standards, autoloading, Composer, PDO or ORM tools (relies on prepared mysql_* queries, which is bad.) and there are alot of mistakes I did which I no longer do. It was a project which never supposed to be open sourced. I put it here just for reference purposes. Use it on your own risk.

**Introduction**

Sobafire is a localised e-sports platform focused on League of Legends game, where users can create visual guides, rate or comment them, or join tournaments.

Live version can be found here: http://sobafire.com (until domain expires)

**Installation**

1. Import `sobafiredb.sql` to your MySQL database. (If you want to support other databases, update the DBAL which can be found under `classes/Database.class.php`.
2. Put all the files under root directory of your web server.
3. Configure `config.php` and add your database credentials.
4. Search for `sobafire.com` on all files. Some things may be hardcoded just to support my domain and edit them to match your new domain.

**Content**

Although I kept content up to date with League of Legends during 2011 and early 2012, database as of now fell pretty behind.

For example, some champions like Evelynn, Karma, Master Yi got reworks, some had their skills changed, alot of new champions released (we support pre-Zed era), mastery pages got reworked during season 3, new items and new runes added to game, some items (RIP Heart of Gold) removed from the game, icons updated etc. Database in current state has alot of work to do. 

> I strongly suggest wikifying your content tables or developing a bot which updates database. Riot Games likes to do balance patches so often (especially during season 3) and I assure you, your database will fall behind pretty quickly if you don't consider those options.

**License**

Released everything under MIT license so you can do whatever you want with this project. It's all yours. 

Assets under `themes/default/images/lol` folder belongs to Riot Games.
