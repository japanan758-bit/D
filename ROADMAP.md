# Project Roadmap & Future Development

## Phase 1: Current Status (Completed)
- Unified Admin Panel (Filament V3).
- Medical Records Management (Prescriptions, Vitals).
- Patient & Invoice Management.
- Visual Theme Builder.
- Role-Based Access Control.

## Phase 2: Advanced Features (Next Steps)
- **Payment Gateway Integration:** Implement Stripe/PayPal using the `PaymentGatewayInterface` already scaffolded in `app/Services/Payment`.
- **SMS Integration:** Connect `NotificationService` to an SMS provider (Twilio/Gateway) for real-time appointment reminders.
- **Patient Portal V2:** Enhance the patient dashboard to view Invoices and Prescriptions history directly.

## Phase 3: Scalability & Mobile
- **API Development:** Expose RESTful APIs for a future Mobile App (Flutter/React Native).
- **Performance:** Implement Redis caching for the Appointment slots.
- **Localization:** Complete `lang/en.json` and ensure 100% RTL/LTR compatibility.

## Missing/Optional Files Note
- `tests/`: Basic test directory structure exists. Feature tests should be written for the new Filament resources.
- `lang/`: Arabic JSON translation created. English needs expansion.
