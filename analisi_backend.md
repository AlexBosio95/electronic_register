CommonController

- metodo index generico (parametrizzata perchè ogni index ha alcune piccole particolarità come il nome dell pagina);

- varie funzioni di appoggio continueranno ad essere nei tratti;

- provare a standardizzare anche le altre provando a utilizzare le closure;

ApiController

- gestisce le chiamate api che vengono fatte nel codice (ora sono "a casaccio" tra i controller, dovranno poi essere tutte in uno unico);


Autenticare le chiamate API verso le rotte Laravel:

- sfrutto il middleware auth:sanctum di Laravel.
- introduco una rotta di login sul file api.php, la uso per ottenere il token, lo metto nelle chiamate API e le proteggo così.

