Analizzando il codice attuale della funzione index del PresenceController e del MarksController, considerando anche l'aggiunta di Vue, ipotizzo che, per il refactor del controller index, sia opportuno fare in modo che la funzione ritorni solo:
- le classi che può gestire il prof;
- il ruolo dello user;
- la pagina corrente;
- le pagine che può vedere;
Si può valutare se possibile scrivere una volta sola la funzione index (o con un tratto o con una specie di CommonController) ed evitare quindi di duplicarla troppe volte.
Per quanto riguarda l'organizzazione delle viste, in base al ruolo dello user, la index deve far atterrarre l'utente su pagine diverse. 
Ritengo quindi siano da fare directory separate, una per i teacher in cui atterrano tutti i teacher e forse gli admin (teacher.blade) e una per gli student (student.blade). Poi sarà Vue a definire la pagina da far vedere in base al parametro page ritornnato dalla index. Biosgna però ragionarci.
Siccome ipotizzo siano molto diverse, anche in questo caso, nella cartella dei componenti Vue, si potrebbero fare cartelle separate.
Bisogna anche tenere in considerazione che, per alcune pagine gestite SOLO dagli admin, non sono necessari il calendario e il menu delle classi. Al momento, mi viene in mente solo un banale v-if controllando il ruolo e la pagina, ma anche in questo caso valuterei di fare qualcosa di più robusto e sicuro utilizzando il controller ed evitare di demandare questo controllo al Javascript.
Come già discusso, per gestire meglio la visualizzazione dei componenti (Presenze, Voti, Note ecc) ritengo necessario utilizzare il Vue router e aggiungerlo all'applicazione. Per intenderci sostituire i v-if nel MainComponent con il routing che in base alla pagina chiami il componente giusto.
Penso sia superfluo dirlo ma bisogna eliminare tutte le viste e tutto il codice vecchio.
Definire bene quale sarà il ruollo dell'admin e se potrà agire su presenze/assenze/voti/note. Se definiamo che può essere un prof direi di sì. A questo punto potrebbe essere una sorta di amministratore e quindi potrebbe starci.
Possiamo anche decidere che non lo possa fare, sarebbe però strano che in quanto admin non possa modificare ogni cosa del sistema. Però se così fosse sarebbe più di un prof e quindi avrebbe un potere quasi eccessivo. Bisogna ragionarci.


