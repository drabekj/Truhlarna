INSERT INTO `Login` (`ID_Login`, `Username`, `Password`, `ID_Zam`) VALUES ('1', 'Admin', 'truhlarna', NULL);

INSERT INTO `Zamestnanec` (`ID_Zam`, `Jmeno`, `Prijmeni`) VALUES ('1', 'Petr', 'Banan');

INSERT INTO `Objednavka` (`Cislo_VP`,`Jmeno`,`Od`,`Do`,`Sazba`) VALUES ('1','NULL','2015-01-01','2015-01-07', '1');

INSERT INTO `Pracovni_den` (`Datum`,`Cislo_VP`,`Hodiny`, `ID_Zam`) VALUES ('2015-01-01', '1','5','1');
INSERT INTO `Pracovni_den` (`Datum`,`Cislo_VP`,`Hodiny`, `ID_Zam`) VALUES ('2015-01-02', '1','5','1');
