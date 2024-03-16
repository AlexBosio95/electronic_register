Funzionamento:

Il controller PresenceController, funzione index:
inizializzo il campo current_date e current_day alla data e giorno corrente, mi prendo i dati dello user, il nome della pagina, le classi del professore e chiamo la view teacher.presents.
Quando atterro sull'interfaccia, avrò i dati delle presenze della classe del giorno corrente. Se voglio cambiare giorno clicco sulla data in alto a sinistra, dal calendario seleziono il giorno che voglio
(che verrà modificato) e cliccando cerca rifaccio la chiamata.
Il server a quel punto riceverà il giorno e data che ho indicato io dal calendario e mi restituirà i dati delle presenze di quel giorno.
N.B. se non c'è un orario o non ci sono presenze, chiaramente l'interfaccia conterrà una tabella vuota.

Per inserire una nuova presenza, cliccare sul pulsante più in ogni casella e verrà aggiunta la presenza per quello studente (riga della colonna) per quell'ora (intestazione della colonna).
Per modificarla basta cliccare sul pulsante P o A già presente nella cella corrispondente all'alunno e all'ora.
in entrambi i casi, dopo la modifica, viene visualizzato un messaggio di successo che scoparirà dopo alcuni secondi.
La validazione è stata effettuata col Validator di javascript per le funzioni index, store e update. Al momento nessun altro metodo del controller fa qualcosa (valutare cosa fare).
In caso di errori, esce un messaggio di alert che indica quale validazione è fallita.

Implementazione:

Utilizzati 3 componenti principali, calendar, button e button-modifica.

Il calendario è il più complesso:
il componente, calendar.blade.php contiene sia il html/blade sia del javascript (col vantaggio che verrà caricato SOLO al momento del caricamento del calendario)
Se si controlla il componente si può vedere che viene inizializzato tutto ciò che serve, giorno corrente, mese corrente, dayMonthAndYear (variabile che contiene giorno mese e anno
e la uso in interfaccia come intestazione del calendario, che è la cella più in alto a sinistra della tabella).
Quando cambio giorno sul calendario, aggiorno prima di tutto le variabili del javascript per mantenere tutto coerente (ovviamente in fase di test controllare che sia così, può essermi sfuggito qualcosa).
Le funzioni sono setCurrentDay e updateHiddenDate (quando clicco sul calendario aggiorna le date che serviranno sia per inserire la nuova presenza, sia per ottenere i dati delle presenze di un determinato giorno).
e poi anche il campo Hidden current_date, così una volta cliccato Cerca mi ritornano le presenze di quel giorno.

I due componenti button e button-modifica sono i bottoni che servono per aprire i modali che conterranno i form per l'aggiornamento/inserimento dei record delle presenze.
Per decidere quale modale aprire uso una variabile isOpen (apre il modale dell'inserimento) e isOpenPut (che apre quello per la modifica). Per questo vedere il funzionamento di Tailwind
La logica è che nel componente si definisce la variabile x-show="isOpenPut" o x-show="isOpen" e al click di uno dei due bottoni sopra citati questa variabile diventa true. Quando invece clicco il bottone per chiudere
diventa false. Sostanzialmente, per aprirli e chiuderli bisogna controllare questo flag.
I due modali, quindi, sono uno per l'aggiunta di una nuova presenza e l'altro per l'aggiornamento.
Entrambi contengono un form per l'aggiornamento o l'inserimento dei dati. 
I campi HiddenHour e HiddenDate del form di inserimento, come indicato sopra, vengono aggiornati rispettivamente cliccando sul pulsante per inserire una nuova presenza e cliccando il calendario.
