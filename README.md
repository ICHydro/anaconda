# Anaconda

Anaconda is an experimental web platform for the visualization of environmental information to non-scientific audiences. The software is produced by several projects of the research group led by Dr. Buytaert at Imperial College London, such as Hydroflux India and Mountain-EVO.

# Licence

The Yii framework is released under the BSD licence 
(see [Licence_yii](docs/LICENSE_yii.md)).

The time series visualization framework is released under the MIT licence 
(see [Licence_tsvis](docs/LICENSE_tsvis.md)).

All other parts of the software are released under the MIT licence
(see [Licence](docs/LICENSE.md)).

# Installation
Recommended and fastest way to set up demo is to use [Vagrant](https://www.vagrantup.com/), with [VirtualBox](https://www.virtualbox.org/) provider installed.
Then from anaconda root directory simply run:
```
vagrant up
``` 
You can then directly access demo page in your browser at 192.168.10.80, and connect to 
anaconda postgres database at localhost:5433 (check Vagrantfile). 

If you don't want to use Vagrant then please follow notes [here](installation/README.md).

# Development
Please follow notes [here](docs/development/README.md).


# Contact

For more information contact [Wouter Buytaert](http://www.imperial.ac.uk/people/w.buytaert).

# Acknowledgements

The time series visualization is based on Kaliatech's [dygraphs dynamic zooming example] (https://github.com/kaliatech/dygraphs-dynamiczooming-example). 
