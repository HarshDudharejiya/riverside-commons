# Riverside Commons - Drupal Assessment

This repository contains the completed frontend assessment for the Riverside Commons project. It features a custom Drupal theme utilizing Single Directory Components (SDCs), strictly adhering to Figma design fidelity and WCAG 2.2 accessibility standards.

## 🎥 Demonstration
**Watch the 2-3 minute walkthrough here:** [Insert YouTube/Loom Link Here or state "Included in repository as demo.mp4"]

## 📦 Included Artifacts
* **Database Dump:** `database/db.sql`
* **Files Directory:** already added so no need to add
* **Configuration:** `config/sync` and ddev settings files alredy have this setting

## 🚀 Setup & Reproduction Instructions

This project is built using **DDEV**. To reproduce this build from a clean clone so that `drush cim` reports no overrides, please follow these exact steps:

1. **Clone the repository and install dependencies:**
   ```bash
   git clone <your-repository-url>
   cd <your-repository-directory>
   ddev start
   ddev composer install
   ddev import-db database/db.sql
   ddev drush cr
   ddev drush uli