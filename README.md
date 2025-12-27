# digital_voting_system
# 🗳️ Digital Voting System
### PHP & MySQL Based Online Election Platform

This is a **web-based Digital Voting System** developed using **PHP, MySQL, HTML, and CSS**.  
The project is designed for **college / institutional elections** where an **admin manages elections** and **voters cast votes online** in a secure and time-controlled manner.

---

## 📌 Features

### 👨‍💼 Admin Features
- Secure admin login
- Add and manage candidates
- Upload candidate-related files (PDF / CSV)
- Upload voter PDF documents
- Add and manage voters
- Create and manage elections
- Set voting start and end time
- Publish election results
- View previous elections
- **Delete completed elections**
- Logout functionality

### 🧑‍🎓 Voter Features
- Secure voter login
- View active election
- Vote only during allowed voting time
- One vote per election
- View published results
- Logout functionality

---

## 🛠️ Technologies Used

- **Frontend:** HTML5, CSS3 (animated & responsive UI)
- **Backend:** PHP (Session-based authentication)
- **Database:** MySQL
- **Server:** XAMPP / Apache

---

## 🗄️ Database Information

### Database Name

### Tables Used

- `admin`  
  Stores admin login credentials

- `voters`  
  Stores voter details

- `voter_pdf_uploads`  
  Stores uploaded voter PDF files

- `candidates`  
  Stores candidate details

- `candidate_file_uploads`  
  Stores candidate-related uploaded files

- `election`  
  Stores election details (current & previous elections)

- `votes`  
  Stores votes cast by voters

- `voting_time`  
  Stores election start and end time

---

## 📂 Project Folder Structure

digital_voting_system/
│── uploads/
│
│── add_candidate.php
│── add_voter.php
│── admin_dashboard.php
│── admin_login.php
│── db.php
│── delete_candidate.php
│── delete_candidate_file.php
│── delete_election.php
│── delete_file.php
│── delete_voter.php
│── index.php
│── logout.php
│── manage_elections.php
│── nav_buttons.php
│── previous_elections.php
│── publish_result.php
│── set_election.php
│── upload_candidates.php
│── upload_files.php
│── view_candidate_files.php
│── view_candidates.php
│── view_uploaded_files.php
│── view_voters.php
│── vote.php
│── voter_dashboard.php
│── voter_login.php
│── voting.php

---

## 🔁 Election Workflow

### 🟢 Election Creation
1. Admin logs in
2. Admin creates a new election
3. Admin sets voting start and end time
4. Candidates and voters are added

### 🗳️ Voting Phase
1. Voter logs in
2. Voting allowed only within set time
3. Vote is stored in the `votes` table
4. Duplicate voting is prevented

### 🔴 Election Completion
1. Voting time ends automatically
2. Admin publishes results
3. Completed elections are visible in **Previous Elections**

### 🗑️ Delete Previous Election
1. Admin selects a completed election
2. Election record is deleted
3. Votes related to that election are removed
4. System is ready for a new election

---

## 🔐 Security & Validation

- Session-based authentication
- Admin-only access to election controls
- Voting allowed only within defined time
- One vote per voter per election
- Confirmation prompts before deleting elections

---

## 🧪 How to Run the Project

1. Install **XAMPP**
2. Start **Apache** and **MySQL**
3. Create database:
4. Import tables into the database
5. Place the project folder inside:
6. Open browser and run:

---

## 🎓 Viva / Exam Explanation

**How does the system handle multiple elections?**

Each election is stored separately in the `election` table.  
Votes are linked to elections, and completed elections can be deleted by the admin, allowing fresh elections to be conducted.

---

## 🚀 Future Enhancements

- Election-wise result analytics
- Graphical vote statistics
- OTP-based voter verification
- Mobile-responsive enhancements
- Role-based admin access

---

## 👨‍💻 Author

**Kumareshwarlal B M**  
Digital Voting System  
PHP & MySQL Web Application

---

e
