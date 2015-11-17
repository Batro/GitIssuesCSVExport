#User manual

This php script was written to retrieve GitHub issues automatically on a repository.

To use it you only need the Curl library, and, of course, an access to a GitHub repository that contains issues.

You'll need to know how many hundreds of issues there are in this repo, because the GitHub API only allows groups of
100 pages gotten at a time.

So let's get started!

First, in a shell, go to the directory where issues.php is and run the following command:
`curl -u ":YourGitHubUserName" 'https://api.github.com/repos/:RepoOwnerUserName/:RepoName/issues?per_page=100&state=all' > issue1.json`

That is if you have less than 100 issues and you want all of them, even the closed ones.
If you want only the closed ones, change '&state=all' by '&state=closed'. If you want only the open ones, simply remove
this parameter.

Now let's see what to do if you have more than 100 issues.

You'll have to create multiple json files, with a number, like this : issueX.json, where X is your page number.
If you have between 100 and 199 issues, you'll have issue1.json and issue2.json, if you have between 200 and 299 issues,
you'll have issue1.json, issue2.json and issue3.json, etc...

Then, you just run the previous command X times, with an extra parameter. It will now look like this:

`curl -u ":YourGitHubUserName" 'https://api.github.com/repos/:RepoOwnerUserName/:RepoName/issues?per_page=100&state=all@page=X' > issueX.json`

Start with X=1, then increment X until you are sure you have gathered all the issues you want in this repo.

Finally, in your shell, run the following command :
`php issues.php > issues.csv`

Tadaaa! Your CSV file containing all the issues you wanted is now in that same directory!
Note that the encoding should be fine even for special characters like French accents when opened with Excel (which
have ANSI as its default encoding, and our CSV is encoded in UTF-8).