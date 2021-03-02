# Tacalboard Server - Deployment notes and cheat-sheet

## Update model
* Irregular bug fixes.
* Regular half-a-year updates providing new features.

## Order of deployment process
1. Server software
2. Client software

For large server updates (e.g. from version 1.x to 2.0) we provide new URL for api request (e.g. http://x.yz/v2/*).
In this scenario, bearing not updated client applications in mind, server software is obligated to detect client version and provide suitable redirection.
After releasing next big version (e.g. 2.0), old can be updated using only small bug/security-fixes but only for legitimate reasons. 

## Versioning model
Application **v. X.Y.Z** where:
* **X** - represents changes abandoning old api endpoints or changing their behaviour, there where not be backward compatibility for old clients,
* **Y** - represents all half-a-year feature updates if implementation doesn't abandon old api endpoints, clients with older version than this still could use this server version in older applications, backward compatibility is guaranteed,
* **Z** - any other small bug-fixes update number.

### Example compatibility note
* Client v. 1.0, 1.0.2, 1.0.5, etc. can connect to server v. 1.0, 1.0.3, etc.
* Client v. 1.0, 1.0.2, 1.0.5, etc. can connect to server v. 1.1, 1.1.5, 1.4, etc. because server provide backward compatibility, but client will not provide new features for end-user.
* Client v. 1.1+ cannot exist if server is in v. 1.0.x, because server should be updated first (look at *"Order of deployment"*).
* Client v. 1.0, 1.5, 1.5.2, etc. cannot connect to server v. 2.0, 2.1, 2.1.3, etc. but server should provide functionality to handle old request using other api url address (e.g. http://x.yz/v1/*) for half of year (for next big update). **THE ONLY** reason to not provide backward functionality is big security leak that can affect new api version.
