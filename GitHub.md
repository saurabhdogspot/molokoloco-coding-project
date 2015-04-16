# TODO #

  * http://help.github.com/git-cheat-sheets/
  * http://think-like-a-git.net/epic.html
  * http://www.vogella.de/articles/Git/article.html
  * http://www.arthurkoziel.com/2008/05/02/git-configuration/

```

ssh -v git@github.com

//---
git add .
git status // to see what changes are going to be commited
git commit -m 'Some descriptive commit message'
git push origin master
Now, when I use gh-pages, there are only a few more commands that I have to use after the above:

git checkout gh-pages // go to the gh-pages branch
git rebase master // bring gh-pages up to date with master
git push origin gh-pages // commit the changes
git checkout master // return to the master branch

//---

git status
git fetch origin
git pull origin master


Commentaire ?

esc + :wq + enter

//---

mkdir FastWebStart
cd FastWebStart
git init
touch README
git add README
git commit -m 'first commit'
git remote add origin git@github.com:molokoloco/FastWebStart.git
git push origin master

//---

git commit 'DOM of sprites elements are now re-used + added options presets too ;)'

declare -x GIT_SSH="C:\Program Files\Git\bin\ssh.exe"
http://help.github.com/troubleshooting-ssh/

git log --pretty=oneline

git config --global user.name "Your Name"
git config --global user.email "your_email@whatever.com"

//---

 http://doc.fedora-fr.org/wiki/Gestion_et_contr%C3%B4le_de_versions_avec_Git

to create a branch (by typing git branch foo)

git@github.com:molokoloco/branding.git

$ git clone git@github.com:dash30/thinktank.git 
$ git remote add upstream git://github.com/ginatrapani/thinktank.git

//---

$ git fetch upstream 
$ git checkout 100-retweet-bugfix
$ git rebase upstream

//---

git add .
git commit -m 'Fixing some code...'
git push ssh://git@github.com/molokoloco/jQuery.boxFx.git master:master

// Committing all changes in a repository

git commit -a -m 'Fixing some code...'

//---
// Undo a commit and redo

// If it's a private branch you can amend the commit:
git commit --amend

// If it's a shared branch you'll have to make a new commit:
git commit -m 'Remove accidental .class files.'
git push

```

  * http://gitref.org/branching/#tag

```
$ git tag -a v0.9 558151a
$ git log --oneline --decorate --graph

$ git checkout develop
$ git push --tags

$ git tag -a v0.94 -m 'Version 0.94'
$ ./git tag -l v1.4.2.*
// v1.4.2.1 v1.4.2.2 ...


```