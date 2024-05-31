Dalla mia analisi ho capito che non è possibile applicare l'utilizzo del vue-router per quanto riguarda l'utilizzo del menù. 
Mantenendo la situazione attuale la cosa migliore è che:
- Ogni bottione del menu chiama il controller (che definiremo generale) passando per la index (come già accade adesso dovrà passare il paramentro relativo alla pagina)
- La index ritornerà sempre una sola vista (Vue si occperà di restituire il componente corretto).
- Mettere le funzioni nei controller dedicati, attualmente le chiamate sono tutte dentro il marksController anche cose non inerenti. 
- Rimuovere le viste non più utilizzate. (es. marks.blade.php)
- (questo è per avere una situazione più pulita) dividere quello che per noi è una page e quello che è un componente vue in diverse cartelle.

Schema 
Bottone menu -> controller generale index -> view.blade (dove è montato vue) [Vue si occupa di far vedere solo il componente che ha il tag page corretto]

--------------------------------------------

L'alternativa è avere diverse viste balde e non usare vue per l'indicizazione della view da visualizzare, 
questo a mio avviso è una soluzione che mi piace meno, perchè impica diverse criticità:
- Tante view in cui ci sono diversi componenti vue che non possono passarsi i dati in quanto non sono fratelli ne figli. 
- Controller comune che sarebbe molto più complesso, in quanto dovrebbe ritornare ogni volta una vista diversa.
