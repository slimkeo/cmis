# Payment System - Corrected Implementation

## Overview
The payments.php is now an ADMIN/TELLER interface for adding subscription payments to the existing `statements` table.

## How It Works

### Flow
1. **Admin/Teller** navigates to Payments section
2. **Searches for member** by:
   - ID Number
   - Name
   - Surname
   - Passbook Number
3. **Selects months** to add subscription payments for (1-12)
4. **Enters amount per month**
5. **Selects status** (Verified or Pending)
6. **Submits** → Creates entries in `statements` table

### Form Fields
- **Member Search**: Auto-complete search for member
- **Amount Per Month**: Monthly subscription amount (in Emalangeni)
- **Select Months**: Checkboxes for months (Jan-Dec current year)
- **Total Amount**: Auto-calculated (months × amount)
- **Description**: Default "Subscription payment - Burial Scheme"
- **Status**: Verified or Pending

### Data Storage
Payments are stored in the existing `statements` table:
```
statements {
  id: auto-increment
  memberid: selected member's id
  date: current date (when recorded)
  description: "Subscription payment - Burial Scheme - January 2026"
  amount: monthly fee (from form)
  type: "subscription"
  status: "verified" or "pending" (from form)
  user: logged-in user's id (from session)
  created_at: timestamp
}
```

## Implementation Details

### Files Modified

#### 1. `application/views/backend/burial/payments.php`
- Single form for adding subscription payments
- Live member search with AJAX
- Month selection with auto-calculation
- Dynamic form visibility based on member selection

#### 2. `application/controllers/Burial.php`
- Added `payments()` function
- Added `search_members()` AJAX endpoint
- Added `add_subscription()` form handler

### Key Functions

#### `payments()`
Main page handler that loads the payments view.

#### `search_members()` - AJAX Endpoint
```php
POST /index.php?burial/search_members
Input: search (string, min 2 chars)
Output: JSON {success: bool, members: []}
```
Searches members table by:
- idnumber
- name
- surname
- passbook_no

#### `add_subscription()` - Form Handler
```php
POST /index.php?burial/add_subscription
Input:
  - selected_member_id: int
  - months[]: array of YYYY-MM strings
  - amount_per_month: float
  - description: string (optional)
  - status: string (verified|pending)
Output: Redirect with flash message
```

Validation:
- Member must exist
- At least one month selected
- Valid amount > 0
- Month format validation (YYYY-MM)

Creates `statements` records for each month.

## Database Schema Used

### statements table
```sql
CREATE TABLE `statements` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `memberid` int(11) unsigned NOT NULL,
  `date` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` varchar(50) NOT NULL,        -- 'subscription', 'deposit', 'withdrawal', etc
  `status` varchar(50) NOT NULL,      -- 'verified', 'pending'
  `user` int(11) unsigned NOT NULL,   -- User who recorded the transaction
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`memberid`) REFERENCES `members` (`id`),
  FOREIGN KEY (`user`) REFERENCES `user` (`id`)
)
```

## Session Requirements

```php
$_SESSION['user_login'] = 1        // Must be 1 for authorized access
$_SESSION['user_id'] = $user->id   // ID of logged-in user (teller/admin)
```

## Usage Example

### Step 1: Admin searches for member
```
Type in search: "John" or "1234567890" (ID number) or "12345" (passbook)
AJAX returns matching members
First match auto-selected
```

### Step 2: Admin selects months
```
Check: January 2026, February 2026, March 2026
Total = 3 months × amount entered
```

### Step 3: Admin enters payment details
```
Amount Per Month: 400.00
Total Amount: 1200.00 (auto-calculated)
Status: Verified
Description: (default or custom)
```

### Step 4: Submit
```
Creates 3 records in statements table:
  1. Jan 2026 subscription - 400.00 - verified - user_id X
  2. Feb 2026 subscription - 400.00 - verified - user_id X
  3. Mar 2026 subscription - 400.00 - verified - user_id X
```

## Features

✅ **Member Search**: Live search by ID, name, or passbook
✅ **Multi-Month Support**: Add subscriptions for multiple months in one form
✅ **Auto-Calculation**: Total updates dynamically
✅ **Existing Table**: Uses statements table (no new table needed)
✅ **Audit Trail**: Records user_id who added the payment
✅ **Status Control**: Admin can mark as verified or pending
✅ **Description Tracking**: Auto-generates descriptive text

## Error Handling

| Error | Message |
|-------|---------|
| No member selected | "Please select a member" |
| No months selected | "Please select at least one month" |
| Invalid amount | "Please enter a valid amount" |
| Member not found | "Member not found" |
| Search < 2 chars | Returns empty results |

## Security

✅ Session validation (user_login check)
✅ User ID recorded from session
✅ Input validation
✅ SQL injection prevention (active record)
✅ Member isolation (only selected member affected)
✅ Month format validation

## Notes

- No new table creation needed
- Uses existing `statements` table infrastructure
- Type field set to "subscription" for easy filtering
- User field tracks who recorded the payment
- Status field allows verification workflow
- Works with existing member and user tables
