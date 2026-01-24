## 🧪 How to Test (Reviewer Guide)

Since the requirement focuses on the `can_edit` logic which requires Authentication context, 
but there is no specific requirement for a Login endpoint, I provided a **Helper Route** to easily generate tokens for testing.

### 1. Generate Token (Dev Only)
**POST** `/api/dev/login`
```json
{
    "email": "admin@example.com" // or manager@example.com / user@example.com
}