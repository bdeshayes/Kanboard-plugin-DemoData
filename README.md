# DemoData plugin for Kanboard

This plugin allows you to generate sample data so you can put Kanboard thru its paces in no time.

## Prerequisites

[![Kanboard version](https://img.shields.io/badge/Kanboard-1.0.48-red.svg)](https://kanboard.net/news/version-1.0.48)

## Installation

**Manually, latest release:**

  1. Navigate to the `plugins` directory, located in the root installation directory of Kanboard
  2. Create the `DemoData` folder
  3. Download the latest release [here](https://github.com/bdeshayes/Kanboard-plugin-DemoData/releases/tag/v1.0.0)
  4. Extract all files in the directory contained in the archive file you downloaded in the `DemoData` directory created previously

**Using the Git CLI, bleeding-edge code:**

  1. Navigate to the `plugins` directory, located in the root installation directory of Kanboard
  2. `git clone https://github.com/bdeshayes/Kanboard-plugin-DemoData.git DemoData`

You can check if the plugin is correctly installed in the **Preferences** > **Plugins** menu.

## Usage

Trash the db.sqlite database in the data directory.
Login as admin / admin. Click on the far right pull down menu and choose Settings.
At the bottom of the leftside list click Generate Demo Data
