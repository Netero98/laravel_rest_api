## How to setup local environment via docker
1. make init

## How to test some API methods
1. Get all vehicle models (public):
curl \
   -X GET \
   -H "Content-Type: application/json" \
   -H "Accept: application/json" \
   http://localhost/api/vehicle-models
2. Receive bearer token for test user. Test user is added by seeder. Put token in all guarded requests:
curl \
   -X POST \
   -H "Content-Type: application/json" \
   -H "Accept: application/json" \
   -d '{"email": "test@example.com", "password": "password", "token_name": "my"}' \
   http://localhost/api/token
3. Add vehicle model: (as many times as you want)
curl \
   -X POST \
   -H "Content-Type: application/json" \
   -H "Accept: application/json" \
   -H "Authorization: Bearer YOUR_TOKEN" \
   -d '{"vehicle_model_id": "9ac6f94b-fe4e-4bcb-a4fd-e9951a3ca552", "year": "2015", "mileage_km": "100500", "color": "white"}' \
   http://localhost/api/vehicles
4. Get all user models (should be all added earlier):
curl \
   -X GET \
   -H "Content-Type: application/json" \
   -H "Accept: application/json" \
   -H "Authorization: Bearer YOUR_TOKEN" \
   http://localhost/api/vehicles
