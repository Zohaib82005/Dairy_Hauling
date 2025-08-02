# 🥛 Milk Hauling Management System

A complete milk collection and hauling management system built with **PHP Laravel** and **MySQL**, designed to manage dairy milk pickup operations from multiple farms and deliver them to designated plants efficiently.

---

## 📌 Project Overview

This web-based platform streamlines the operations of milk haulers, farms, and dairy plants. It provides:
- Route & ticket assignments to haulers
- Milk collection tracking from farms
- Volume calculations using stick readings or scales
- Barcode scanning for automated identification
- PDF ticket generation and email dispatch at the plant

---

## 🧑‍🤝‍🧑 User Roles

| Role       | Capabilities |
|------------|--------------|
| **Admin**  | Create/manage routes, farms, haulers, tickets, tanks, patrons, and plants |
| **Driver/User** | Assigned to specific haulers; perform milk collection, scan barcodes, record volumes |
| **Plant Intake Team (Optional)** | View delivered tickets, approve/reject loads, download reports |

---

## 🚛 Functional Modules

### 🛣️ Routes & Tickets
- Each **hauler** is assigned **routes**
- **Tickets** are generated for each trip (date-wise, route-wise)
- **Farms** are linked with specific routes

### 🐄 Farm Stops & Milk Collection
- Drivers scan barcodes to identify **Farm ID**, **Patron ID**, **Tank ID**
- Milk volume is calculated using:
  - Stick Readings
  - Scale at Farm
  - Estimated Value
  - Scale at Plant


### 📷 Barcode Scanning
- Barcode format: `TR01FARM001TANK001PTR445`
- Extracts: Route ID, Farm ID, Tank ID, Patron ID
- Works via phone camera (using `BarcodeDetector` JS API)

### 🧾 PDF Ticket Generation
- Final ticket generated at the **Plant**
- Sample barcode scanned
- Final volume, delivery time, and signature included
- Ticket PDF auto-emailed to intake team

---

## 💬 Chat Module (New Feature)
- Drivers can **chat with their assigned hauler**
- Stored messages by user_id, hauler_id

---

## 🧠 Tech Stack

- **Backend:** Laravel 10 (MVC)
- **Database:** MySQL
- **Frontend:** Blade + Bootstrap 5
- **Barcode Detection:** BarcodeDetector API + JS
- **PDF Generation:** domPDF / barryvdh/laravel-dompdf
- **Deployment:** Works on both local and LAN networks

---



