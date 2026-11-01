-- eFFe Document: aggiornamento per le password cifrate (hash)
-- Da eseguire una sola volta su un database creato con la versione 1.0.
-- Le password esistenti restano valide: vengono convertite in hash
-- automaticamente al primo accesso di ciascun operatore.

ALTER TABLE `operatori` MODIFY `password` varchar(255) NOT NULL DEFAULT '';
