<?php defined('BASEPATH') or exit('No direct script access allowed');

class WhatsApp extends MX_Controller
{
    public $bg = '
                data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEBLAEsAAD/4iOISUNDX1BST0ZJTEUAAQEAACN4bGNtcwIQAABtbnRyUkdCIFhZWiAH3wALAAoADAASADhhY3NwKm5peAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA9tYAAQAAAADTLWxjbXMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAtkZXNjAAABCAAAALBjcHJ0AAABuAAAARJ3dHB0AAACzAAAABRjaGFkAAAC4AAAACxyWFlaAAADDAAAABRiWFlaAAADIAAAABRnWFlaAAADNAAAABRyVFJDAAADSAAAIAxnVFJDAAADSAAAIAxiVFJDAAADSAAAIAxjaHJtAAAjVAAAACRkZXNjAAAAAAAAABxzUkdCLWVsbGUtVjItc3JnYnRyYy5pY2MAAAAAAAAAAAAAAB0AcwBSAEcAQgAtAGUAbABsAGUALQBWADIALQBzAHIAZwBiAHQAcgBjAC4AaQBjAGMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHRleHQAAAAAQ29weXJpZ2h0IDIwMTUsIEVsbGUgU3RvbmUgKHdlYnNpdGU6IGh0dHA6Ly9uaW5lZGVncmVlc2JlbG93LmNvbS87IGVtYWlsOiBlbGxlc3RvbmVAbmluZWRlZ3JlZXNiZWxvdy5jb20pLiBUaGlzIElDQyBwcm9maWxlIGlzIGxpY2Vuc2VkIHVuZGVyIGEgQ3JlYXRpdmUgQ29tbW9ucyBBdHRyaWJ1dGlvbi1TaGFyZUFsaWtlIDMuMCBVbnBvcnRlZCBMaWNlbnNlIChodHRwczovL2NyZWF0aXZlY29tbW9ucy5vcmcvbGljZW5zZXMvYnktc2EvMy4wL2xlZ2FsY29kZSkuAAAAAFhZWiAAAAAAAAD21gABAAAAANMtc2YzMgAAAAAAAQxCAAAF3v//8yUAAAeTAAD9kP//+6H///2iAAAD3AAAwG5YWVogAAAAAAAAb6AAADj1AAADkFhZWiAAAAAAAAAknwAAD4QAALbEWFlaIAAAAAAAAGKXAAC3hwAAGNljdXJ2AAAAAAAAEAAAAAABAAIABAAFAAYABwAJAAoACwAMAA4ADwAQABEAEwAUABUAFgAYABkAGgAbABwAHgAfACAAIQAjACQAJQAmACgAKQAqACsALQAuAC8AMAAyADMANAA1ADcAOAA5ADoAOwA9AD4APwBAAEIAQwBEAEUARwBIAEkASgBMAE0ATgBPAFEAUgBTAFQAVQBXAFgAWQBaAFwAXQBeAF8AYQBiAGMAZABmAGcAaABpAGsAbABtAG4AbwBxAHIAcwB0AHYAdwB4AHkAewB8AH0AfgCAAIEAggCDAIUAhgCHAIgAiQCLAIwAjQCOAJAAkQCSAJMAlQCWAJcAmACaAJsAnACdAJ8AoAChAKIApAClAKYApwCoAKoAqwCsAK0ArwCwALEAsgC0ALUAtgC3ALkAugC7ALwAvgC/AMAAwQDCAMQAxQDGAMcAyQDKAMsAzADOAM8A0ADRANMA1ADVANcA2ADZANoA3ADdAN4A4ADhAOIA5ADlAOYA6ADpAOoA7ADtAO8A8ADxAPMA9AD2APcA+AD6APsA/QD+AP8BAQECAQQBBQEHAQgBCgELAQ0BDgEPAREBEgEUARUBFwEYARoBGwEdAR8BIAEiASMBJQEmASgBKQErAS0BLgEwATEBMwE0ATYBOAE5ATsBPAE+AUABQQFDAUUBRgFIAUoBSwFNAU8BUAFSAVQBVQFXAVkBWgFcAV4BYAFhAWMBZQFnAWgBagFsAW4BbwFxAXMBdQF2AXgBegF8AX4BfwGBAYMBhQGHAYkBigGMAY4BkAGSAZQBlgGXAZkBmwGdAZ8BoQGjAaUBpwGpAasBrAGuAbABsgG0AbYBuAG6AbwBvgHAAcIBxAHGAcgBygHMAc4B0AHSAdQB1gHYAdoB3AHeAeEB4wHlAecB6QHrAe0B7wHxAfMB9QH4AfoB/AH+AgACAgIEAgcCCQILAg0CDwISAhQCFgIYAhoCHQIfAiECIwIlAigCKgIsAi4CMQIzAjUCOAI6AjwCPgJBAkMCRQJIAkoCTAJPAlECUwJWAlgCWgJdAl8CYQJkAmYCaQJrAm0CcAJyAnUCdwJ5AnwCfgKBAoMChgKIAosCjQKQApIClQKXApoCnAKfAqECpAKmAqkCqwKuArACswK1ArgCuwK9AsACwgLFAsgCygLNAs8C0gLVAtcC2gLdAt8C4gLkAucC6gLsAu8C8gL1AvcC+gL9Av8DAgMFAwgDCgMNAxADEwMVAxgDGwMeAyADIwMmAykDLAMuAzEDNAM3AzoDPQM/A0IDRQNIA0sDTgNRA1QDVgNZA1wDXwNiA2UDaANrA24DcQN0A3cDegN9A4ADggOFA4gDiwOOA5EDlAOYA5sDngOhA6QDpwOqA60DsAOzA7YDuQO8A78DwgPFA8kDzAPPA9ID1QPYA9sD3wPiA+UD6APrA+4D8gP1A/gD+wP+BAIEBQQIBAsEDwQSBBUEGAQcBB8EIgQlBCkELAQvBDMENgQ5BD0EQARDBEcESgRNBFEEVARXBFsEXgRiBGUEaARsBG8EcwR2BHkEfQSABIQEhwSLBI4EkgSVBJkEnASgBKMEpwSqBK4EsQS1BLgEvAS/BMMExgTKBM4E0QTVBNgE3ATgBOME5wTqBO4E8gT1BPkE/QUABQQFCAULBQ8FEwUWBRoFHgUiBSUFKQUtBTEFNAU4BTwFQAVDBUcFSwVPBVIFVgVaBV4FYgVmBWkFbQVxBXUFeQV9BYEFhAWIBYwFkAWUBZgFnAWgBaQFqAWsBa8FswW3BbsFvwXDBccFywXPBdMF1wXbBd8F4wXnBesF7wX0BfgF/AYABgQGCAYMBhAGFAYYBhwGIQYlBikGLQYxBjUGOQY+BkIGRgZKBk4GUwZXBlsGXwZjBmgGbAZwBnQGeQZ9BoEGhQaKBo4GkgaXBpsGnwakBqgGrAaxBrUGuQa+BsIGxgbLBs8G1AbYBtwG4QblBuoG7gbyBvcG+wcABwQHCQcNBxIHFgcbBx8HJAcoBy0HMQc2BzoHPwdDB0gHTQdRB1YHWgdfB2MHaAdtB3EHdgd7B38HhAeJB40HkgeXB5sHoAelB6kHrgezB7cHvAfBB8YHygfPB9QH2QfdB+IH5wfsB/EH9Qf6B/8IBAgJCA0IEggXCBwIIQgmCCsILwg0CDkIPghDCEgITQhSCFcIXAhhCGYIawhwCHUIegh/CIQIiQiOCJMImAidCKIIpwisCLEItgi7CMAIxQjKCM8I1AjZCN8I5AjpCO4I8wj4CP0JAwkICQ0JEgkXCR0JIgknCSwJMQk3CTwJQQlGCUwJUQlWCVsJYQlmCWsJcQl2CXsJgQmGCYsJkQmWCZsJoQmmCasJsQm2CbwJwQnGCcwJ0QnXCdwJ4gnnCe0J8gn4Cf0KAgoICg0KEwoZCh4KJAopCi8KNAo6Cj8KRQpKClAKVgpbCmEKZgpsCnIKdwp9CoMKiAqOCpQKmQqfCqUKqgqwCrYKvArBCscKzQrTCtgK3grkCuoK7wr1CvsLAQsHCwwLEgsYCx4LJAsqCy8LNQs7C0ELRwtNC1MLWQtfC2QLagtwC3YLfAuCC4gLjguUC5oLoAumC6wLsgu4C74LxAvKC9AL1gvcC+IL6QvvC/UL+wwBDAcMDQwTDBkMIAwmDCwMMgw4DD4MRQxLDFEMVwxdDGQMagxwDHYMfQyDDIkMjwyWDJwMogyoDK8MtQy7DMIMyAzODNUM2wzhDOgM7gz1DPsNAQ0IDQ4NFQ0bDSENKA0uDTUNOw1CDUgNTw1VDVwNYg1pDW8Ndg18DYMNiQ2QDZYNnQ2kDaoNsQ23Db4NxQ3LDdIN2Q3fDeYN7A3zDfoOAQ4HDg4OFQ4bDiIOKQ4vDjYOPQ5EDkoOUQ5YDl8OZg5sDnMOeg6BDogOjg6VDpwOow6qDrEOuA6+DsUOzA7TDtoO4Q7oDu8O9g79DwQPCw8SDxkPIA8nDy4PNQ88D0MPSg9RD1gPXw9mD20PdA97D4IPiQ+QD5gPnw+mD60PtA+7D8IPyg/RD9gP3w/mD+0P9Q/8EAMQChASEBkQIBAnEC8QNhA9EEQQTBBTEFoQYhBpEHAQeBB/EIYQjhCVEJ0QpBCrELMQuhDCEMkQ0BDYEN8Q5xDuEPYQ/REFEQwRFBEbESMRKhEyETkRQRFIEVARVxFfEWcRbhF2EX0RhRGNEZQRnBGkEasRsxG7EcIRyhHSEdkR4RHpEfAR+BIAEggSDxIXEh8SJxIuEjYSPhJGEk4SVRJdEmUSbRJ1En0ShBKMEpQSnBKkEqwStBK8EsQSzBLUEtsS4xLrEvMS+xMDEwsTExMbEyMTKxMzEzsTRBNME1QTXBNkE2wTdBN8E4QTjBOUE50TpROtE7UTvRPFE80T1hPeE+YT7hP2E/8UBxQPFBcUIBQoFDAUOBRBFEkUURRaFGIUahRzFHsUgxSMFJQUnBSlFK0UthS+FMYUzxTXFOAU6BTxFPkVARUKFRIVGxUjFSwVNBU9FUUVThVXFV8VaBVwFXkVgRWKFZMVmxWkFawVtRW+FcYVzxXYFeAV6RXyFfoWAxYMFhQWHRYmFi8WNxZAFkkWUhZaFmMWbBZ1Fn4WhhaPFpgWoRaqFrMWuxbEFs0W1hbfFugW8Rb6FwMXDBcUFx0XJhcvFzgXQRdKF1MXXBdlF24XdxeAF4kXkhecF6UXrhe3F8AXyRfSF9sX5BftF/cYABgJGBIYGxgkGC4YNxhAGEkYUhhcGGUYbhh3GIEYihiTGJwYphivGLgYwhjLGNQY3hjnGPAY+hkDGQwZFhkfGSkZMhk7GUUZThlYGWEZaxl0GX4ZhxmRGZoZpBmtGbcZwBnKGdMZ3RnmGfAZ+hoDGg0aFhogGioaMxo9GkYaUBpaGmMabRp3GoEaihqUGp4apxqxGrsaxRrOGtga4hrsGvUa/xsJGxMbHRsnGzAbOhtEG04bWBtiG2wbdRt/G4kbkxudG6cbsRu7G8UbzxvZG+Mb7Rv3HAEcCxwVHB8cKRwzHD0cRxxRHFscZRxwHHochByOHJgcohysHLYcwRzLHNUc3xzpHPQc/h0IHRIdHB0nHTEdOx1FHVAdWh1kHW8deR2DHY4dmB2iHa0dtx3BHcwd1h3hHesd9R4AHgoeFR4fHioeNB4+HkkeUx5eHmgecx59Hogekx6dHqgesh69Hsce0h7cHuce8h78HwcfEh8cHycfMh88H0cfUh9cH2cfch98H4cfkh+dH6cfsh+9H8gf0h/dH+gf8x/+IAggEyAeICkgNCA/IEogVCBfIGogdSCAIIsgliChIKwgtyDCIM0g2CDjIO4g+SEEIQ8hGiElITAhOyFGIVEhXCFnIXIhfiGJIZQhnyGqIbUhwCHMIdch4iHtIfgiBCIPIhoiJSIwIjwiRyJSIl4iaSJ0In8iiyKWIqEirSK4IsMizyLaIuYi8SL8IwgjEyMfIyojNSNBI0wjWCNjI28jeiOGI5EjnSOoI7QjvyPLI9Yj4iPuI/kkBSQQJBwkKCQzJD8kSyRWJGIkbiR5JIUkkSScJKgktCS/JMsk1yTjJO4k+iUGJRIlHiUpJTUlQSVNJVklZSVwJXwliCWUJaAlrCW4JcQl0CXcJecl8yX/JgsmFyYjJi8mOyZHJlMmXyZrJncmhCaQJpwmqCa0JsAmzCbYJuQm8Cb9JwknFSchJy0nOSdGJ1InXidqJ3YngyePJ5snpye0J8AnzCfZJ+Un8Sf9KAooFigjKC8oOyhIKFQoYChtKHkohiiSKJ4oqyi3KMQo0CjdKOko9ikCKQ8pGykoKTQpQSlNKVopZylzKYApjCmZKaYpsim/Kcwp2CnlKfEp/ioLKhgqJCoxKj4qSipXKmQqcSp9KooqlyqkKrEqvSrKKtcq5CrxKv4rCisXKyQrMSs+K0srWCtlK3IrfyuMK5krpSuyK78rzCvZK+Yr8ywBLA4sGywoLDUsQixPLFwsaSx2LIMskCyeLKssuCzFLNIs3yztLPotBy0ULSEtLy08LUktVi1kLXEtfi2LLZktpi2zLcEtzi3bLekt9i4ELhEuHi4sLjkuRy5ULmEuby58Loouly6lLrIuwC7NLtsu6C72LwMvES8eLywvOi9HL1UvYi9wL34viy+ZL6cvtC/CL9Av3S/rL/kwBjAUMCIwLzA9MEswWTBnMHQwgjCQMJ4wrDC5MMcw1TDjMPEw/zENMRoxKDE2MUQxUjFgMW4xfDGKMZgxpjG0McIx0DHeMewx+jIIMhYyJDIyMkAyTjJcMmoyeTKHMpUyozKxMr8yzTLcMuoy+DMGMxQzIzMxMz8zTTNcM2ozeDOGM5UzozOxM8AzzjPcM+sz+TQHNBY0JDQzNEE0TzReNGw0ezSJNJg0pjS1NMM00jTgNO80/TUMNRo1KTU3NUY1VDVjNXI1gDWPNZ01rDW7Nck12DXnNfU2BDYTNiE2MDY/Nk42XDZrNno2iTaXNqY2tTbENtM24TbwNv83DjcdNyw3OzdJN1g3Zzd2N4U3lDejN7I3wTfQN9837jf9OAw4GzgqODk4SDhXOGY4dTiEOJM4ojixOME40DjfOO44/TkMORs5Kzk6OUk5WDlnOXc5hjmVOaQ5tDnDOdI54TnxOgA6DzofOi46PTpNOlw6azp7Ooo6mjqpOrg6yDrXOuc69jsGOxU7JTs0O0Q7UztjO3I7gjuRO6E7sDvAO9A73zvvO/48DjwePC08PTxNPFw8bDx8PIs8mzyrPLo8yjzaPOo8+T0JPRk9KT05PUg9WD1oPXg9iD2YPac9tz3HPdc95z33Pgc+Fz4nPjc+Rz5XPmc+dz6HPpc+pz63Psc+1z7nPvc/Bz8XPyc/Nz9HP1c/Zz94P4g/mD+oP7g/yD/ZP+k/+UAJQBlAKkA6QEpAWkBrQHtAi0CcQKxAvEDNQN1A7UD+QQ5BHkEvQT9BT0FgQXBBgUGRQaJBskHDQdNB5EH0QgVCFUImQjZCR0JXQmhCeEKJQppCqkK7QstC3ELtQv1DDkMfQy9DQENRQ2FDckODQ5RDpEO1Q8ZD10PnQ/hECUQaRCtEO0RMRF1EbkR/RJBEoUSyRMJE00TkRPVFBkUXRShFOUVKRVtFbEV9RY5Fn0WwRcFF0kXjRfRGBUYXRihGOUZKRltGbEZ9Ro9GoEaxRsJG00bkRvZHB0cYRylHO0dMR11HbkeAR5FHoke0R8VH1kfoR/lICkgcSC1IP0hQSGFIc0iESJZIp0i5SMpI3EjtSP9JEEkiSTNJRUlWSWhJekmLSZ1JrknASdJJ40n1SgZKGEoqSjtKTUpfSnFKgkqUSqZKt0rJSttK7Ur/SxBLIks0S0ZLWEtpS3tLjUufS7FLw0vVS+dL+UwKTBxMLkxATFJMZEx2TIhMmkysTL5M0EziTPRNBk0ZTStNPU1PTWFNc02FTZdNqU28Tc5N4E3yTgROF04pTjtOTU5fTnJOhE6WTqlOu07NTt9O8k8ETxZPKU87T05PYE9yT4VPl0+qT7xPzk/hT/NQBlAYUCtQPVBQUGJQdVCHUJpQrVC/UNJQ5FD3UQlRHFEvUUFRVFFnUXlRjFGfUbFRxFHXUelR/FIPUiJSNFJHUlpSbVKAUpJSpVK4UstS3lLxUwRTFlMpUzxTT1NiU3VTiFObU65TwVPUU+dT+lQNVCBUM1RGVFlUbFR/VJJUpVS4VMtU3lTyVQVVGFUrVT5VUVVlVXhVi1WeVbFVxVXYVetV/lYSViVWOFZLVl9WclaFVplWrFa/VtNW5lb6Vw1XIFc0V0dXW1duV4JXlVepV7xX0FfjV/dYClgeWDFYRVhYWGxYgFiTWKdYuljOWOJY9VkJWR1ZMFlEWVhZa1l/WZNZp1m6Wc5Z4ln2WglaHVoxWkVaWVpsWoBalFqoWrxa0FrkWvhbC1sfWzNbR1tbW29bg1uXW6tbv1vTW+db+1wPXCNcN1xLXGBcdFyIXJxcsFzEXNhc7F0BXRVdKV09XVFdZV16XY5dol22Xctd313zXgheHF4wXkReWV5tXoJell6qXr9e017nXvxfEF8lXzlfTl9iX3dfi1+gX7RfyV/dX/JgBmAbYC9gRGBYYG1ggmCWYKtgv2DUYOlg/WESYSdhO2FQYWVhemGOYaNhuGHNYeFh9mILYiBiNWJJYl5ic2KIYp1ismLHYtti8GMFYxpjL2NEY1ljbmODY5hjrWPCY9dj7GQBZBZkK2RAZFVkamR/ZJVkqmS/ZNRk6WT+ZRNlKWU+ZVNlaGV9ZZNlqGW9ZdJl6GX9ZhJmJ2Y9ZlJmZ2Z9ZpJmp2a9ZtJm6Gb9ZxJnKGc9Z1NnaGd+Z5NnqWe+Z9Rn6Wf/aBRoKmg/aFVoamiAaJZoq2jBaNZo7GkCaRdpLWlDaVhpbmmEaZlpr2nFadtp8GoGahxqMmpIal1qc2qJap9qtWrKauBq9msMayJrOGtOa2RremuQa6ZrvGvSa+hr/mwUbCpsQGxWbGxsgmyYbK5sxGzabPBtBm0cbTNtSW1fbXVti22hbbhtzm3kbfpuEW4nbj1uU25qboBulm6tbsNu2W7wbwZvHG8zb0lvYG92b4xvo2+5b9Bv5m/9cBNwKnBAcFdwbXCEcJpwsXDHcN5w9HELcSJxOHFPcWZxfHGTcapxwHHXce5yBHIbcjJySHJfcnZyjXKkcrpy0XLocv9zFnMsc0NzWnNxc4hzn3O2c81z5HP6dBF0KHQ/dFZ0bXSEdJt0snTJdOB093UOdSZ1PXVUdWt1gnWZdbB1x3XedfZ2DXYkdjt2UnZqdoF2mHavdsd23nb1dwx3JHc7d1J3aneBd5h3sHfHd9539ngNeCV4PHhUeGt4gniaeLF4yXjgePh5D3kneT55VnlueYV5nXm0ecx543n7ehN6KnpCelp6cXqJeqF6uHrQeuh7AHsXey97R3tfe3Z7jnume7571nvufAV8HXw1fE18ZXx9fJV8rXzFfNx89H0MfSR9PH1UfWx9hH2cfbR9zX3lff1+FX4tfkV+XX51fo1+pX6+ftZ+7n8Gfx5/N39Pf2d/f3+Xf7B/yH/gf/mAEYApgEGAWoBygIqAo4C7gNSA7IEEgR2BNYFOgWaBf4GXgbCByIHhgfmCEoIqgkOCW4J0goyCpYK+gtaC74MHgyCDOYNRg2qDg4Obg7SDzYPlg/6EF4QwhEiEYYR6hJOErITEhN2E9oUPhSiFQYVahXKFi4Wkhb2F1oXvhgiGIYY6hlOGbIaFhp6Gt4bQhumHAocbhzSHTYdnh4CHmYeyh8uH5If9iBeIMIhJiGKIe4iViK6Ix4jgiPqJE4ksiUaJX4l4iZGJq4nEid6J94oQiiqKQ4pdinaKj4qpisKK3Ir1iw+LKItCi1uLdYuOi6iLwovbi/WMDowojEKMW4x1jI+MqIzCjNyM9Y0PjSmNQo1cjXaNkI2pjcON3Y33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
                ';
    function __construct()
    {
        parent::__construct();
        $this->load->library('wkhtmltoimage');
        $this->load->model(
            array(
                'm_setup',
                'm_cabang',
                'm_cuti',
                'm_dinas',
                'm_ijin',
                'm_lembur',
                'm_sppb',
            )
        );
    }

    public function index()
    {
        $nama = $this->session->userdata('nik');
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));

        echo json_encode(
            $this->m_cuti->q_whatsapp_collect_where('
            AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
            AND ck.status = \'A\' AND whatsappsent = FALSE
            ORDER BY input_date
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result()
        );
    }

    public function imageCreator($message = null, $output = null)
    {
        return $this->wkhtmltoimage->convert($message, 400, 400, $output, false);
    }

        public function imageCreatorojt($message = null, $output = null)
    {
        return $this->wkhtmltoimage->convert($message, 620, 620, $output, false);
    }

    public function auth()
    {
        $nama = $this->session->userdata('nik');
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'api/token/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'user_name' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-USER:' . $branch . '\'', 'root'),
                'password' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-PASSWORD:' . $branch . '\'', '#Admin#'),
            ),
        )
        );
        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        $body = json_decode($response);
        curl_close($curl);
        if ($body) {
            if ($info['http_code'] == 200) {
                try {
                    $setup = $this->m_setup->q_mst_exist(array('kdoption' => 'WA-REFRESH:' . $branch));
                    if ($setup) {
                        $data = array(
                            'value1' => $body->refresh,
                            'status' => 'T',
                            'update_by' => $nama,
                            'update_date' => date('Y-m-d H:i:s')
                        );
                        $this->db->where('kdoption', 'WA-REFRESH:' . $branch);
                        $this->db->update('sc_mst.option', $data);
                    } else {
                        $data = array(
                            'kdoption' => 'WA-REFRESH:' . $branch,
                            'nmoption' => 'TOKEN WA-REFRESH ' . $branch,
                            'value1' => $body->refresh,
                            'group_option' => 'WA',
                            'status' => 'T',
                            'input_by' => $nama,
                            'input_date' => date('Y-m-d H:i:s')
                        );
                        $this->db->insert('sc_mst.option', $data);
                    }
                    $setup = $this->m_setup->q_mst_exist(array('kdoption' => 'WA-ACCESS:' . $branch));
                    if ($setup) {
                        $data = array(
                            'value1' => $body->access,
                            'status' => 'T',
                            'update_by' => $nama,
                            'update_date' => date('Y-m-d H:i:s')
                        );
                        $this->db->where('kdoption', 'WA-ACCESS:' . $branch);
                        $this->db->update('sc_mst.option', $data);
                    } else {
                        $data = array(
                            'kdoption' => 'WA-ACCESS:' . $branch,
                            'nmoption' => 'TOKEN WA-ACCESS ' . $branch,
                            'value1' => $body->access,
                            'group_option' => 'WA'
                        );
                        $this->db->insert('sc_mst.option', $data);
                    }
                    header('Content-Type: application/json');
                    echo json_encode(
                        array(
                            'return' => true,
                            'info' => $info,
                            'body' => $body,
                        ), JSON_PRETTY_PRINT);
                    return true;
                } catch (\Exception $e) {
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'return' => false,
                'info' => $info,
                'body' => $body,
            ), JSON_PRETTY_PRINT);
        return false;
    }

    public function refresh()
    {
        $nama = $this->session->userdata('nik');
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'api/token/refresh/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('refresh' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-REFRESH:' . $branch . '\'', 'refresh')),
        )
        );
        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        $body = json_decode($response);
        curl_close($curl);
        if ($body) {
            if ($info['http_code'] == 200) {
                try {
                    $setup = $this->m_setup->q_mst_exist(array('kdoption' => 'WA-REFRESH:' . $branch));
                    if ($setup) {
                        $data = array(
                            'value1' => $body->refresh,
                            'status' => 'T',
                            'update_by' => $nama,
                            'update_date' => date('Y-m-d H:i:s')
                        );
                        $this->db->where('kdoption', 'WA-REFRESH:' . $branch);
                        $this->db->update('sc_mst.option', $data);
                    } else {
                        $data = array(
                            'kdoption' => 'WA-REFRESH:' . $branch,
                            'nmoption' => 'TOKEN WA-REFRESH ' . $branch,
                            'value1' => $body->refresh,
                            'group_option' => 'WA',
                            'status' => 'T',
                            'input_by' => $nama,
                            'input_date' => date('Y-m-d H:i:s')
                        );
                        $this->db->insert('sc_mst.option', $data);
                    }
                    $setup = $this->m_setup->q_mst_exist(array('kdoption' => 'WA-ACCESS:' . $branch));
                    if ($setup) {
                        $data = array(
                            'value1' => $body->access,
                            'status' => 'T',
                            'update_by' => $nama,
                            'update_date' => date('Y-m-d H:i:s')
                        );
                        $this->db->where('kdoption', 'WA-ACCESS:' . $branch);
                        $this->db->update('sc_mst.option', $data);
                    } else {
                        $data = array(
                            'kdoption' => 'WA-ACCESS:' . $branch,
                            'nmoption' => 'TOKEN WA-ACCESS ' . $branch,
                            'value1' => $body->access,
                            'group_option' => 'WA',
                            'status' => 'T',
                            'input_by' => $nama,
                            'input_date' => date('Y-m-d H:i:s')
                        );
                        $this->db->insert('sc_mst.option', $data);
                    }
                    header('Content-Type: application/json');
                    echo json_encode(
                        array(
                            'return' => true,
                            'info' => $info,
                            'body' => $body,
                        ), JSON_PRETTY_PRINT);
                    return true;
                } catch (\Exception $e) {
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'return' => false,
                'info' => $info,
                'body' => $body,
            ), JSON_PRETTY_PRINT);
        return false;
    }

    public function shuffle($len = 4)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $charcode = '';
        for ($loop = 0; $loop < $len; $loop++) {
            $charcode .= str_shuffle($chars)[0];
        }
        return $charcode;
    }

    public function msgcuti($sent = 'false')
    {
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));
        $resendTimeRange = $this->m_setup->q_mst_read_value(' AND parameter = \'WA:RESEND:PERIOD\'', '8');
        if ($sent == 'true'){
            $filter = ' and ( ck.properties->>\'last_sent\' is not null AND to_timestamp(ck.properties->>\'last_sent\', \'YYYY-MM-DD HH24:MI:SS\') < NOW() - INTERVAL \' '.$resendTimeRange.' hours\' ) ';
        }else{
            $filter = '';
        }
        $messages = [];
        foreach ($this->m_cuti->q_whatsapp_collect_where($filter.'
        AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
        AND ck.status = \'A\' AND whatsappsent = '.$sent.'
        AND (whatsappaccept = false AND whatsappreject = false)
        ORDER BY input_date desc, retry DESC
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {
            $ref = $this->shuffle();
            $message = '' .
                '<table width=\'400\' background=\'' . $this->bg . '\'>
                    <thead>
                      <tr>
                        <th colspan=\'3\'><b>PERSETUJUAN CUTI</b></th>
                      </tr>
                      <tr><th colspan=\'3\'>&nbsp;</th></tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td colspan=\'2\'>NOMOR DOK </td>
                        <td colspan=\'1\'><b>' . $item->nodok . '</b></td>
                      </tr>
                      <tr><td colspan="3">&nbsp;</td></tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Nama Karyawan</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->nama . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Tipe Pengajuan</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>CUTI</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Tanggal Cuti</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->tgl_mulai . ' sd ' . $item->tgl_selesai . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Jumlah Cuti</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->jumlah_cuti . ' hari</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Keterangan Cuti</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->keterangan . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Pelimpahan Tugas</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->pelimpahan . '</b></td>
                      </tr>
                    </tbody>
                </table>'
                . '';
            $output = 'assets/img/approval/cuti/' . $item->nodok . '_' . $ref . '.jpg';
            $this->imageCreator($message, $output);
            array_push(
                $messages,
                array(
                    'message' => json_encode(
                        array(
                            'path' => str_replace('\\', '/', base_url($output)),
                            'caption' => 'PERSETUJUAN *CUTI ' . $item->nodok . '*' . PHP_EOL . PHP_EOL
                                . '_Balas:_' . PHP_EOL
                                . '_Ya = Setuju, Tidak = Tolak_' . PHP_EOL . PHP_EOL
                                . '_Ref:' . $ref . '_'
                        )
                    ),
                    'message_type' => 'imageMessage',
                    'outbox_for' => $item->approverjid,
                    'is_interactive' => true,
                    'retry' => 1,
                    'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                    'properties' => array(
                        'type' => 'A.I.C',
                        'objectid' => $item->nodok,
                        'approver' => $item->approver,
                        'retry' => (int)$item->retry + 1,
                    ),
                )
            );
        }
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($messages),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                        'Content-Type: application/json'
                    ),
                )
            );
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->m_cuti->q_trx_update(
                            array(
                                'whatsappsent' => TRUE,
                                'retry' => $row->properties->retry,
                                'properties' => json_encode(array(
                                    'last_sent' => date('Y-m-d H:i:s'),
                                )),
                            ),
                            array('TRIM(nodok)' => $row->properties->objectid)
                        );
                        $this->db->insert(
                            'sc_log.success_notifications',
                            array(
                                'modul' => 'notification',
                                'message' => json_encode($body),
                                'properties' => json_encode($info),
                                'input_by' => 'SYSTEM',
                                'input_date' => date('Y-m-d H:i:s'),
                            )
                        );
                    }
                    header('Content-Type: application/json');
                    echo json_encode(
                        array(
                            'return' => false,
                            'info' => $info,
                            'body' => $body,
                        ),
                        JSON_PRETTY_PRINT
                    );
                    return true;
                } else {
                    $this->db->insert(
                        'sc_log.error_notifications',
                        array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        )
                    );
                }
            }
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => false,
                    'info' => $info,
                    'body' => $body,
                ),
                JSON_PRETTY_PRINT
            );
            return false;
        } else {
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => true,
                    'info' => array(),
                    'body' => array(),
                    'message' => 'Empty data will skip post to whatsapp bot',
                ),
                JSON_PRETTY_PRINT
            );
            return true;
        }
    }

    public function msgijindt($sent = 'false')
    {
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));
        $resendTimeRange = $this->m_setup->q_mst_read_value(' AND parameter = \'WA:RESEND:PERIOD\'', '8');
        if ($sent == 'true'){
            $filter = ' and ( ck.properties->>\'last_sent\' is not null AND to_timestamp(ck.properties->>\'last_sent\', \'YYYY-MM-DD HH24:MI:SS\') < NOW() - INTERVAL \' '.$resendTimeRange.' hours\' ) ';
        }else{
            $filter = '';
        }
        $messages = [];
        foreach ($this->m_ijin->q_whatsapp_collect_where($filter.' 
        AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
        AND ck.kdijin_absensi = \'DT\' AND ck.status = \'A\' AND whatsappsent = '.$sent.'
        AND (whatsappaccept = false AND whatsappreject = false)
        ORDER BY input_date desc, retry DESC
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {
            $ref = $this->shuffle();
            $message = '' .
                '<table width=\'400\' background=\'' . $this->bg . '\'>
                        <thead>
                          <tr>
                            <th colspan=\'3\'><b>PERSETUJUAN ' . $item->jenis_ijin . '</b></th>
                          </tr>
                          <tr><th colspan=\'3\'>&nbsp;</th></tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td colspan=\'2\'>NOMOR DOK </td>
                            <td colspan=\'1\'><b>' . $item->nodok . '</b></td>
                          </tr>
                          <tr><td colspan="3">&nbsp;</td></tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Nama Karyawan</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->nama . '</b></td>
                          </tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Tipe Pengajuan</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->jenis_ijin . ' ' . $item->tipe_ijin . '</b></td>
                          </tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Tanggal Izin</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->tgl_kerja . '</b></td>
                          </tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Jam Datang</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->jam_mulai . '</b></td>
                          </tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Keterangan Izin</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->keterangan . '</b></td>
                          </tr>
                        </tbody>
                    </table>'
                . '';
            $output = 'assets/img/approval/ijin/' . $item->nodok . '_' . $ref . '.jpg';
            $this->imageCreator($message, $output);

            array_push(
                $messages,
                array(
                    'message' => json_encode(
                        array(
                            'path' => str_replace('\\', '/', base_url($output)),
                            'caption' => 'PERSETUJUAN *' . $item->jenis_ijin . ' ' . $item->nodok . '*' . PHP_EOL . PHP_EOL
                                . '_Balas:_' . PHP_EOL
                                . '_Ya = Setuju, Tidak = Tolak_' . PHP_EOL . PHP_EOL
                                . '_Ref:' . $ref . '_'
                        )
                    ),
                    'message_type' => 'imageMessage',
                    'outbox_for' => $item->approverjid,
                    'is_interactive' => true,
                    'retry' => 1,
                    'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                    'properties' => array(
                        'type' => 'A.I.I',
                        'objectid' => $item->nodok,
                        'approver' => $item->approver,
                        'retry' => (int)$item->retry + 1,
                    ),
                )
            );
        }
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($messages),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                        'Content-Type: application/json'
                    ),
                )
            );
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->m_ijin->q_trx_update(
                            array(
                                'whatsappsent' => TRUE,
                                'retry' => $row->properties->retry,
                                'properties' => json_encode(array(
                                    'last_sent' => date('Y-m-d H:i:s'),
                                )),
                            ),
                            array('TRIM(nodok)' => $row->properties->objectid)
                        );
                        $this->db->insert(
                            'sc_log.success_notifications',
                            array(
                                'modul' => 'notification',
                                'message' => json_encode($body),
                                'properties' => json_encode($info),
                                'input_by' => 'SYSTEM',
                                'input_date' => date('Y-m-d H:i:s'),
                            )
                        );
                    }
                    header('Content-Type: application/json');
                    echo json_encode(
                        array(
                            'return' => false,
                            'info' => $info,
                            'body' => $body,
                        ),
                        JSON_PRETTY_PRINT
                    );
                    return true;
                } else {
                    $this->db->insert(
                        'sc_log.error_notifications',
                        array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        )
                    );
                }
            }
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => false,
                    'info' => $info,
                    'body' => $body,
                ),
                JSON_PRETTY_PRINT
            );
            return false;
        } else {
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => true,
                    'info' => array(),
                    'body' => array(),
                    'message' => 'Empty data will skip post to whatsapp bot',
                ),
                JSON_PRETTY_PRINT
            );
            return true;
        }
    }

    public function msgijinik($sent = 'false')
    {
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));
        $resendTimeRange = $this->m_setup->q_mst_read_value(' AND parameter = \'WA:RESEND:PERIOD\'', '8');
        if ($sent == 'true'){
            $filter = ' and ( ck.properties->>\'last_sent\' is not null AND to_timestamp(ck.properties->>\'last_sent\', \'YYYY-MM-DD HH24:MI:SS\') < NOW() - INTERVAL \' '.$resendTimeRange.' hours\' ) ';
        }else{
            $filter = '';
        }
        //$filter .= ' AND to_char(tgl_kerja, \'YYYYMM\') > \'202412\' ';
        $messages = [];
        foreach ($this->m_ijin->q_whatsapp_collect_where($filter.' 
        AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
        AND ck.kdijin_absensi = \'IK\' AND ck.status = \'A\' AND whatsappsent = '.$sent.'
        AND (whatsappaccept = false AND whatsappreject = false)
        ORDER BY input_date desc, retry DESC
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {
            $ref = $this->shuffle();
            $message = '' .
                '<table width=\'400\' background=\'' . $this->bg . '\'>
                        <thead>
                          <tr>
                            <th colspan=\'3\'><b>PERSETUJUAN ' . $item->jenis_ijin . '</b></th>
                          </tr>
                          <tr><th colspan=\'3\'>&nbsp;</th></tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td colspan=\'2\'>NOMOR DOK </td>
                            <td colspan=\'1\'><b>' . $item->nodok . '</b></td>
                          </tr>
                          <tr><td colspan="3">&nbsp;</td></tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Nama Karyawan</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->nama . '</b></td>
                          </tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Tipe Pengajuan</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->jenis_ijin . ' ' . $item->tipe_ijin . '</b></td>
                          </tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Tanggal Izin</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->tgl_kerja . '</b></td>
                          </tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Jam Mulai</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->jam_mulai . '</b></td>
                          </tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Jam Selesai</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->jam_selesai . '</b></td>
                          </tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Keterangan Izin</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->keterangan . '</b></td>
                          </tr>
                        </tbody>
                    </table>'
                . '';
            $output = 'assets/img/approval/ijin/' . $item->nodok . '_' . $ref . '.jpg';
            $this->imageCreator($message, $output);

            array_push(
                $messages,
                array(
                    'message' => json_encode(
                        array(
                            'path' => str_replace('\\', '/', base_url($output)),
                            'caption' => 'PERSETUJUAN *' . $item->jenis_ijin . ' ' . $item->nodok . '*' . PHP_EOL . PHP_EOL
                                . '_Balas:_' . PHP_EOL
                                . '_Ya = Setuju, Tidak = Tolak_' . PHP_EOL . PHP_EOL
                                . '_Ref:' . $ref . '_'
                        )
                    ),
                    'message_type' => 'imageMessage',
                    'outbox_for' => $item->approverjid,
                    'is_interactive' => true,
                    'retry' => 1,
                    'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                    'properties' => array(
                        'type' => 'A.I.I',
                        'objectid' => $item->nodok,
                        'approver' => $item->approver,
                        'retry' => (int)$item->retry + 1,
                    ),
                )
            );
        }
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($messages),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                        'Content-Type: application/json'
                    ),
                )
            );
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->m_ijin->q_trx_update(
                            array(
                                'whatsappsent' => TRUE,
                                'retry' => $row->properties->retry,
                                'properties' => json_encode(array(
                                    'last_sent' => date('Y-m-d H:i:s'),
                                )),
                            ),
                            array('TRIM(nodok)' => $row->properties->objectid)
                        );
                        $this->db->insert(
                            'sc_log.success_notifications',
                            array(
                                'modul' => 'notification',
                                'message' => json_encode($body),
                                'properties' => json_encode($info),
                                'input_by' => 'SYSTEM',
                                'input_date' => date('Y-m-d H:i:s'),
                            )
                        );
                    }
                    header('Content-Type: application/json');
                    echo json_encode(
                        array(
                            'return' => false,
                            'info' => $info,
                            'body' => $body,
                        ),
                        JSON_PRETTY_PRINT
                    );
                    return true;
                } else {
                    $this->db->insert(
                        'sc_log.error_notifications',
                        array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        )
                    );
                }
            }
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => false,
                    'info' => $info,
                    'body' => $body,
                ),
                JSON_PRETTY_PRINT
            );
            return false;
        } else {
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => true,
                    'info' => array(),
                    'body' => array(),
                    'message' => 'Empty data will skip post to whatsapp bot',
                ),
                JSON_PRETTY_PRINT
            );
            return true;
        }
    }
	
		public function msgskd($sent = 'false')
    {
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));
        $resendTimeRange = $this->m_setup->q_mst_read_value(' AND parameter = \'WA:RESEND:PERIOD\'', '8');
        if ($sent == 'true'){
            $filter = ' and ( ck.properties->>\'last_sent\' is not null AND to_timestamp(ck.properties->>\'last_sent\', \'YYYY-MM-DD HH24:MI:SS\') < NOW() - INTERVAL \' '.$resendTimeRange.' hours\' ) ';
        }else{
            $filter = '';
        }
        $messages = [];
        foreach ($this->m_ijin->q_whatsapp_collect_where($filter.' 
        AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
        AND ck.kdijin_absensi = \'KD\' AND ck.status = \'A\' AND whatsappsent = '.$sent.'
        AND (whatsappaccept = false AND whatsappreject = false)
        ORDER BY input_date desc, retry DESC
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {
            $ref = $this->shuffle();
            $message = '' .
                '<table width=\'400\' background=\'' . $this->bg . '\'>
                        <thead>
                          <tr>
                            <th colspan=\'3\'><b>PERSETUJUAN ' . $item->jenis_ijin . '</b></th>
                          </tr>
                          <tr><th colspan=\'3\'>&nbsp;</th></tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td colspan=\'2\'>NOMOR DOK </td>
                            <td colspan=\'1\'><b>' . $item->nodok . '</b></td>
                          </tr>
                          <tr><td colspan="3">&nbsp;</td></tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Nama Karyawan</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->nama . '</b></td>
                          </tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Tipe Pengajuan</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->jenis_ijin . '</b></td>
                          </tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Tanggal Izin</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->tgl_kerja . '</b></td>
                          </tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Keterangan Izin</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->keterangan . '</b></td>
                          </tr>
                        </tbody>
                    </table>'
                . '';
            $output = 'assets/img/approval/ijin/' . $item->nodok . '_' . $ref . '.jpg';
            $this->imageCreator($message, $output);

            array_push(
                $messages,
                array(
                    'message' => json_encode(
                        array(
                            'path' => str_replace('\\', '/', base_url($output)),
                            'caption' => 'PERSETUJUAN *' . $item->jenis_ijin . ' ' . $item->nodok . '*' . PHP_EOL . PHP_EOL
                                . '_Balas:_' . PHP_EOL
                                . '_Ya = Setuju, Tidak = Tolak_' . PHP_EOL . PHP_EOL
                                . '_Ref:' . $ref . '_'
                        )
                    ),
                    'message_type' => 'imageMessage',
                    'outbox_for' => $item->approverjid,
                    'is_interactive' => true,
                    'retry' => 1,
                    'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                    'properties' => array(
                        'type' => 'A.I.I',
                        'objectid' => $item->nodok,
                        'approver' => $item->approver,
                        'retry' => (int)$item->retry + 1,
                    ),
                )
            );
        }
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($messages),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                        'Content-Type: application/json'
                    ),
                )
            );
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->m_ijin->q_trx_update(
                            array(
                                'whatsappsent' => TRUE,
                                'retry' => $row->properties->retry,
                                'properties' => json_encode(array(
                                    'last_sent' => date('Y-m-d H:i:s'),
                                )),
                            ),
                            array('TRIM(nodok)' => $row->properties->objectid)
                        );
                        $this->db->insert(
                            'sc_log.success_notifications',
                            array(
                                'modul' => 'notification',
                                'message' => json_encode($body),
                                'properties' => json_encode($info),
                                'input_by' => 'SYSTEM',
                                'input_date' => date('Y-m-d H:i:s'),
                            )
                        );
                    }
                    header('Content-Type: application/json');
                    echo json_encode(
                        array(
                            'return' => false,
                            'info' => $info,
                            'body' => $body,
                        ),
                        JSON_PRETTY_PRINT
                    );
                    return true;
                } else {
                    $this->db->insert(
                        'sc_log.error_notifications',
                        array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        )
                    );
                }
            }
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => false,
                    'info' => $info,
                    'body' => $body,
                ),
                JSON_PRETTY_PRINT
            );
            return false;
        } else {
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => true,
                    'info' => array(),
                    'body' => array(),
                    'message' => 'Empty data will skip post to whatsapp bot',
                ),
                JSON_PRETTY_PRINT
            );
            return true;
        }
    }

    public function msgijinpa($sent = 'false')
    {
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));
        $resendTimeRange = $this->m_setup->q_mst_read_value(' AND parameter = \'WA:RESEND:PERIOD\'', '8');
        if ($sent == 'true'){
            $filter = ' and ( ck.properties->>\'last_sent\' is not null AND to_timestamp(ck.properties->>\'last_sent\', \'YYYY-MM-DD HH24:MI:SS\') < NOW() - INTERVAL \' '.$resendTimeRange.' hours\' ) ';
        }else{
            $filter = '';
        }
        $messages = [];
        foreach ($this->m_ijin->q_whatsapp_collect_where($filter.' 
        AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
        AND ck.kdijin_absensi = \'PA\' AND ck.status = \'A\' AND whatsappsent = '.$sent.'
         AND (whatsappaccept = false AND whatsappreject = false)
        ORDER BY input_date desc, retry DESC
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {
            $ref = $this->shuffle();
            $message = '' .
                '<table width=\'400\' background=\'' . $this->bg . '\'>
                            <thead>
                              <tr>
                                <th colspan=\'3\'><b>PERSETUJUAN ' . $item->jenis_ijin . '</b></th>
                              </tr>
                              <tr><th colspan=\'3\'>&nbsp;</th></tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td colspan=\'2\'>NOMOR DOK </td>
                                <td colspan=\'1\'><b>' . $item->nodok . '</b></td>
                              </tr>
                              <tr><td colspan="3">&nbsp;</td></tr>
                              <tr>
                                <td valign=\'top\' style=\'width: 30%;\'>Nama Karyawan</td>
                                <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                                <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->nama . '</b></td>
                              </tr>
                              <tr>
                                <td valign=\'top\' style=\'width: 30%;\'>Tipe Pengajuan</td>
                                <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                                <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->jenis_ijin . ' ' . $item->tipe_ijin . '</b></td>
                              </tr>
                              <tr>
                                <td valign=\'top\' style=\'width: 30%;\'>Tanggal Izin</td>
                                <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                                <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->tgl_kerja . '</b></td>
                              </tr>
                              <tr>
                                <td valign=\'top\' style=\'width: 30%;\'>Jam Pulang</td>
                                <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                                <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->jam_selesai . '</b></td>
                              </tr>
                              <tr>
                                <td valign=\'top\' style=\'width: 30%;\'>Keterangan Izin</td>
                                <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                                <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->keterangan . '</b></td>
                              </tr>
                            </tbody>
                        </table>'
                . '';
            $output = 'assets/img/approval/ijin/' . $item->nodok . '_' . $ref . '.jpg';
            $this->imageCreator($message, $output);

            array_push(
                $messages,
                array(
                    'message' => json_encode(
                        array(
                            'path' => str_replace('\\', '/', base_url($output)),
                            'caption' => 'PERSETUJUAN *' . $item->jenis_ijin . ' ' . $item->nodok . '*' . PHP_EOL . PHP_EOL
                                . '_Balas:_' . PHP_EOL
                                . '_Ya = Setuju, Tidak = Tolak_' . PHP_EOL . PHP_EOL
                                . '_Ref:' . $ref . '_'
                        )
                    ),
                    'message_type' => 'imageMessage',
                    'outbox_for' => $item->approverjid,
                    'is_interactive' => true,
                    'retry' => 1,
                    'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                    'properties' => array(
                        'type' => 'A.I.I',
                        'objectid' => $item->nodok,
                        'approver' => $item->approver,
                        'retry' => (int)$item->retry + 1,
                    ),
                )
            );
        }
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($messages),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                        'Content-Type: application/json'
                    ),
                )
            );
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->m_ijin->q_trx_update(
                            array(
                                'whatsappsent' => TRUE,
                                'retry' => $row->properties->retry,
                                'properties' => json_encode(array(
                                    'last_sent' => date('Y-m-d H:i:s'),
                                )),
                            ),
                            array('TRIM(nodok)' => $row->properties->objectid)
                        );
                        $this->db->insert(
                            'sc_log.success_notifications',
                            array(
                                'modul' => 'notification',
                                'message' => json_encode($body),
                                'properties' => json_encode($info),
                                'input_by' => 'SYSTEM',
                                'input_date' => date('Y-m-d H:i:s'),
                            )
                        );
                    }
                    header('Content-Type: application/json');
                    echo json_encode(
                        array(
                            'return' => false,
                            'info' => $info,
                            'body' => $body,
                        ),
                        JSON_PRETTY_PRINT
                    );
                    return true;
                } else {
                    $this->db->insert(
                        'sc_log.error_notifications',
                        array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        )
                    );
                }
            }
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => false,
                    'info' => $info,
                    'body' => $body,
                ),
                JSON_PRETTY_PRINT
            );
            return false;
        } else {
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => true,
                    'info' => array(),
                    'body' => array(),
                    'message' => 'Empty data will skip post to whatsapp bot',
                ),
                JSON_PRETTY_PRINT
            );
            return true;
        }
    }

    public function msglembur($sent = 'false')
    {
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));
        $resendTimeRange = $this->m_setup->q_mst_read_value(' AND parameter = \'WA:RESEND:PERIOD\'', '8');
        if ($sent == 'true'){
            $filter = ' and ( ck.properties->>\'last_sent\' is not null AND to_timestamp(ck.properties->>\'last_sent\', \'YYYY-MM-DD HH24:MI:SS\') < NOW() - INTERVAL \' '.$resendTimeRange.' hours\' ) ';
        }else{
            $filter = '';
        }
        $messages = [];
        foreach ($this->m_lembur->q_whatsapp_collect_where($filter.'
        AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
        AND ck.status = \'A\' AND whatsappsent = '.$sent.'
        AND (whatsappaccept = false AND whatsappreject = false)
        ORDER BY input_date desc, retry DESC
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {
            $ref = $this->shuffle();
            $message = '' .
                '<table width=\'400\' background=\'' . $this->bg . '\'>
                        <thead>
                          <tr>
                            <th colspan=\'3\'><b>PERSETUJUAN LEMBUR</b></th>
                          </tr>
                          <tr><th colspan=\'3\'>&nbsp;</th></tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td colspan=\'2\'>NOMOR DOK </td>
                            <td colspan=\'1\'><b>' . $item->nodok . '</b></td>
                          </tr>
                          <tr><td colspan="3">&nbsp;</td></tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Nama Karyawan</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->nama . '</b></td>
                          </tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Tipe Pengajuan</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>LEMBUR HARI ' . $item->tipe_lembur . '</b></td>
                          </tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Tanggal Kerja</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->tgl_kerja . '</b></td>
                          </tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Jam Mulai</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->jam_mulai . '</b></td>
                          </tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Jam Selesai</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->jam_selesai . '</b></td>
                          </tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Durasi Lembur</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->durasi . '</b></td>
                          </tr>
                          <tr>
                            <td valign=\'top\' style=\'width: 30%;\'>Keterangan Lembur</td>
                            <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                            <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->keterangan . '</b></td>
                          </tr>
                        </tbody>
                    </table>'
                . '';
            $output = 'assets/img/approval/lembur/' . $item->nodok . '_' . $ref . '.jpg';
            $this->imageCreator($message, $output);

            array_push(
                $messages,
                array(
                    'message' => json_encode(
                        array(
                            'path' => str_replace('\\', '/', base_url($output)),
                            'caption' => 'PERSETUJUAN  LEMBUR *' . $item->nodok . '*' . PHP_EOL . PHP_EOL
                                . '_Balas:_' . PHP_EOL
                                . '_Ya = Setuju, Tidak = Tolak_' . PHP_EOL . PHP_EOL
                                . '_Ref:' . $ref . '_'
                        )
                    ),
                    'message_type' => 'imageMessage',
                    'outbox_for' => $item->approverjid,
                    'is_interactive' => true,
                    'retry' => 1,
                    'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                    'properties' => array(
                        'type' => 'A.I.L',
                        'objectid' => $item->nodok,
                        'approver' => $item->approver,
                        'retry' => (int)$item->retry + 1,
                    ),
                )
            );
        }
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($messages),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                        'Content-Type: application/json'
                    ),
                )
            );
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->m_lembur->q_trx_update(
                            array(
                                'whatsappsent' => TRUE,
                                'retry' => $row->properties->retry,
                                'properties' => json_encode(array(
                                    'last_sent' => date('Y-m-d H:i:s'),
                                )),
                            ),
                            array('TRIM(nodok)' => $row->properties->objectid)
                        );
                        $this->db->insert(
                            'sc_log.success_notifications',
                            array(
                                'modul' => 'notification',
                                'message' => json_encode($body),
                                'properties' => json_encode($info),
                                'input_by' => 'SYSTEM',
                                'input_date' => date('Y-m-d H:i:s'),
                            )
                        );
                    }
                    header('Content-Type: application/json');
                    echo json_encode(
                        array(
                            'return' => false,
                            'info' => $info,
                            'body' => $body,
                        ),
                        JSON_PRETTY_PRINT
                    );
                    return true;
                } else {
                    $this->db->insert(
                        'sc_log.error_notifications',
                        array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        )
                    );
                }
            }
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => false,
                    'info' => $info,
                    'body' => $body,
                ),
                JSON_PRETTY_PRINT
            );
            return false;
        } else {
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => true,
                    'info' => array(),
                    'body' => array(),
                    'message' => 'Empty data will skip post to whatsapp bot',
                ),
                JSON_PRETTY_PRINT
            );
            return true;
        }
    }

    public function msgdinas($sent = 'false')
    {
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));
        $resendTimeRange = $this->m_setup->q_mst_read_value(' AND parameter = \'WA:RESEND:PERIOD\'', '8');
        if ($sent == 'true'){
            $filter = ' and ( ck.properties->>\'last_sent\' is not null AND to_timestamp(ck.properties->>\'last_sent\', \'YYYY-MM-DD HH24:MI:SS\') < NOW() - INTERVAL \' '.$resendTimeRange.' hours\' ) ';
        }else{
            $filter = '';
        }
        $messages = [];
        foreach ($this->m_dinas->q_whatsapp_collect_where($filter.'
        AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
        AND ck.status = \'A\' AND whatsappsent = '.$sent.' 
        AND (whatsappaccept = false AND whatsappreject = false)
        ORDER BY input_date desc, retry DESC
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {
            $ref = $this->shuffle();
            $message = '' .
                '<table width=\'400\' background=\'' . $this->bg . '\'>
                    <thead>
                      <tr>
                        <th colspan=\'3\'><b>PERSETUJUAN DINAS</b></th>
                      </tr>
                      <tr><th colspan=\'3\'>&nbsp;</th></tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td colspan=\'2\'>NOMOR DOK </td>
                        <td colspan=\'1\'><b>' . $item->nodok . '</b></td>
                      </tr>
                      <tr><td colspan="3">&nbsp;</td></tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Nama Karyawan</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->nama . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Tipe Pengajuan</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>DINAS</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Tanggal Dinas</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->tgl_mulai . ' sd ' . $item->tgl_selesai . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Kota Tujuan</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->tujuan_kota . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Keperluan Dinas</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . StrToUpper($item->keperluan) . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Transportasi Dinas</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . StrToUpper($item->transportasi) . ' ' . StrToUpper($item->tipe_transportasi) . '</b></td>
                      </tr>
                    </tbody>
                </table>'
                . '';
            $output = 'assets/img/approval/dinas/' . $item->nodok . '_' . $ref . '.jpg';
            $this->imageCreator($message, $output);

            array_push(
                $messages,
                array(
                    'message' => json_encode(
                        array(
                            'path' => str_replace('\\', '/', base_url($output)),
                            'caption' => 'PERSETUJUAN  DINAS *' . $item->nodok . '*' . PHP_EOL . PHP_EOL
                                . '_Balas:_' . PHP_EOL
                                . '_Ya = Setuju, Tidak = Tolak_' . PHP_EOL . PHP_EOL
                                . '_Ref:' . $ref . '_'
                        )
                    ),
                    'message_type' => 'imageMessage',
                    'outbox_for' => $item->approverjid,
                    'is_interactive' => true,
                    'retry' => 1,
                    'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                    'properties' => array(
                        'type' => 'A.I.D',
                        'objectid' => $item->nodok,
                        'approver' => $item->approver,
                        'retry' => (int)$item->retry + 1,
                    ),
                )
            );
        }
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($messages),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                        'Content-Type: application/json'
                    ),
                )
            );
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->m_dinas->q_trx_update(
                            array(
                                'whatsappsent' => TRUE,
                                'retry' => $row->properties->retry,
                                'properties' => json_encode(array(
                                    'last_sent' => date('Y-m-d H:i:s'),
                                )),
                            ),
                            array('TRIM(nodok)' => $row->properties->objectid)
                        );
                        $this->db->insert(
                            'sc_log.success_notifications',
                            array(
                                'modul' => 'notification',
                                'message' => json_encode($body),
                                'properties' => json_encode($info),
                                'input_by' => 'SYSTEM',
                                'input_date' => date('Y-m-d H:i:s'),
                            )
                        );
                    }
                    header('Content-Type: application/json');
                    echo json_encode(
                        array(
                            'return' => false,
                            'info' => $info,
                            'body' => $body,
                        ),
                        JSON_PRETTY_PRINT
                    );
                    return true;
                } else {
                    $this->db->insert(
                        'sc_log.error_notifications',
                        array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        )
                    );
                }
            }
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => false,
                    'info' => $info,
                    'body' => $body,
                ),
                JSON_PRETTY_PRINT
            );
            return false;
        } else {
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => true,
                    'info' => array(),
                    'body' => array(),
                    'message' => 'Empty data will skip post to whatsapp bot',
                ),
                JSON_PRETTY_PRINT
            );
            return true;
        }
    }

    public function msgsppb($sent = 'false')
    {
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));
        $resendTimeRange = $this->m_setup->q_mst_read_value(' AND parameter = \'WA:RESEND:PERIOD\'', '8');
        if ($sent == 'true'){
            $filter = ' and ( ck.properties->>\'last_sent\' is not null AND to_timestamp(ck.properties->>\'last_sent\', \'YYYY-MM-DD HH24:MI:SS\') < NOW() - INTERVAL \' '.$resendTimeRange.' hours\' ) ';
        }else{
            $filter = '';
        }
        $messages = [];
        foreach ($this->m_sppb->q_whatsapp_collect_where($filter.'
        AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
        AND ck.status = \'A\' AND whatsappsent = '.$sent.'
        AND (whatsappaccept = false AND whatsappreject = false)
        ORDER BY input_date desc, retry DESC
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {
            $ref = $this->shuffle();
            $message = '' .
                '<table width=\'400\' background=\'' . $this->bg . '\'>
                    <thead>
                      <tr>
                        <th colspan=\'3\'><b>PERSETUJUAN SPPB</b></th>
                      </tr>
                      <tr><th colspan=\'3\'>&nbsp;</th></tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td colspan=\'2\'>NOMOR DOK </td>
                        <td colspan=\'1\'><b>' . $item->nodok . '</b></td>
                      </tr>
                      <tr><td colspan="3">&nbsp;</td></tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Nama Karyawan</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->nama . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Tipe Pengajuan</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>SPPB</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Tanggal Dokumen</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->formattgldok . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Nama Barang</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . $item->nmbarang . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\'>&nbsp;</td>
                      </tr>
                      <tr>
                        <td valign=\'top\'>&nbsp;</td>
                      </tr>
                    </tbody>
                </table>'
                . '';
            $output = 'assets/img/approval/sppb/' . $item->nodok . '_' . $ref . '.jpg';
            $this->imageCreator($message, $output);

            array_push(
                $messages,
                array(
                    'message' => json_encode(
                        array(
                            'path' => str_replace('\\', '/', base_url($output)),
                            'caption' => 'PERSETUJUAN  SPPB *' . $item->nodok . '*' . PHP_EOL . PHP_EOL
                                . '_Balas:_' . PHP_EOL
                                . '_Ya = Setuju, Tidak = Tolak_' . PHP_EOL . PHP_EOL
                                . '_Ref:' . $ref . '_'
                        )
                    ),
                    'message_type' => 'imageMessage',
                    'outbox_for' => $item->approverjid,
                    'is_interactive' => true,
                    'retry' => 1,
                    'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                    'properties' => array(
                        'type' => 'A.I.S',
                        'objectid' => $item->nodok,
                        'approver' => $item->approver,
                        'retry' => (int)$item->retry + 1,
                    ),
                )
            );
        }
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($messages),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                        'Content-Type: application/json'
                    ),
                )
            );
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->m_sppb->q_trx_update(
                            array(
                                'whatsappsent' => TRUE,
                                'retry' => $row->properties->retry,
                                'properties' => json_encode(array(
                                    'last_sent' => date('Y-m-d H:i:s'),
                                )),
                            ),
                            array('TRIM(nodok)' => $row->properties->objectid)
                        );
                        $this->db->insert(
                            'sc_log.success_notifications',
                            array(
                                'modul' => 'notification',
                                'message' => json_encode($body),
                                'properties' => json_encode($info),
                                'input_by' => 'SYSTEM',
                                'input_date' => date('Y-m-d H:i:s'),
                            )
                        );
                    }
                    header('Content-Type: application/json');
                    echo json_encode(
                        array(
                            'return' => false,
                            'info' => $info,
                            'body' => $body,
                        ),
                        JSON_PRETTY_PRINT
                    );
                    return true;
                } else {
                    $this->db->insert(
                        'sc_log.error_notifications',
                        array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        )
                    );
                }
            }
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => false,
                    'info' => $info,
                    'body' => $body,
                ),
                JSON_PRETTY_PRINT
            );
            return false;
        } else {
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => true,
                    'info' => array(),
                    'body' => array(),
                    'message' => 'Empty data will skip post to whatsapp bot',
                ),
                JSON_PRETTY_PRINT
            );
            return true;
        }
    }

        public function msgpk($status = '')
    {
        $this->load->model(array('secret/M_Secret','Api/M_Pk'));
        $status = 'P';
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));
        $messages = array();
      
            // var_dump($messages);
            // die();

        foreach ($this->M_Pk->q_whatsapp_collect_where(" and coalesce(a.statuspen,'') != '$status'")->result() as $item) {
           $urlsetup = $this->db->query("select value1 from sc_mst.option where trim(kdoption) = 'URL-MSGPK'")->row()->value1;
			 $refurl = $urlsetup . '/pk/list_pk';
             $url = $urlsetup . '/s/'.$item->identifier;
              if(empty($item->statuspen) || $item->statuspen == 'C'){
                    $refurl = $urlsetup . '/pk/list_pkpen';
             }
            $ref = $this->shuffle();
            $message = '' .
                '<table width=\'400\' background=\'' . $this->bg . '\'>
                    <thead>
                      <tr>
                        <th colspan=\'3\'><b>PENILAIAN KARYAWAN KONTRAK</b></th>
                      </tr>
                      <tr><th colspan=\'3\'>&nbsp;</th></tr>
                    </thead>
                    <tbody>
                      <tr><td colspan="3">&nbsp;</td></tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Nama Karyawan</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . trim($item->nmlengkap) . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>NIK</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . trim($item->nik) . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Bagian</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . trim($item->nmdept) . '</b></td>
                      </tr>
                     <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Jabatan</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . trim($item->nmjabatan) . '</b></td>
                      </tr>
                        <tr>
                          <td valign=\'top\' style=\'width: 30%;\'>Tanggal Berakhir</td>
                          <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                          <td valign=\'top\' style=\'width: 65%;\'><b>' . trim($item->tgl_selesai1) . '</b></td>
                        </tr>
                         <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Jenis Kontrak</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . trim($item->nmkepegawaian) . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Status</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . (trim($item->deskappr) !== '' ? trim($item->deskappr) : 'MENUNGGU PENILAIAN ATASAN 1') . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\'>&nbsp;</td>
                      </tr>
                      <tr>
                        <td valign=\'top\'>&nbsp;</td>
                      </tr>
                    </tbody>
                </table>'
                . '';
            $output = 'assets/img/notifpk/' . $item->nodok . '_' . $ref . '.jpg';
            $fullpath = (ENVIRONMENT == 'development' ? 'https://dummyimage.com/300/09f/fff.png' : base_url($output));
            //$fullpath = base_url($output);
            $this->imageCreator($message, $output);

            // var_dump($fullpath);
            // exit;

             if (empty($item->statuspen) || trim($item->statuspen) == 'C') {
                $appr = trim($item->nmlengkapa1);
            } elseif (trim($item->statuspen) == 'N') {
                $appr = trim($item->nmlengkapa2);
            } else {
                $appr = trim($item->nmlengkap_appr);
            }
            
            array_push(
                $messages,
                array(
                    'message' => json_encode(
                        array(
                            'path' => str_replace('\\', '/', $fullpath),
                            'caption' => 'Yth ' . $appr . PHP_EOL . PHP_EOL . '*Harap Segera menilai/menyetujui dokumen Penilaian Karyawan yang tertera diatas*' . PHP_EOL . PHP_EOL .$url. PHP_EOL . PHP_EOL
                            . 'Jika ada pertanyaan silahkan hubungi bagian HRGA' . PHP_EOL . PHP_EOL
                            . 'Terima Kasih' . PHP_EOL
                            . 'Ref:' . $ref . '_' 
                        )
                    ),
                    'message_type' => 'imageMessage',
                    'is_interactive' => false,
                    'outbox_for' => trim( $item->approver),
                    'retry' => 1,
                    'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                    'properties' => array(
                        'reference' => $ref,
                        'employeeid' =>  $item->nik,
                        //'range' => $after,
                    ),
                )
            );

                 if (empty($item->statuspen || trim($item->statuspen) == 'C')) {
                     $employee_id = trim($item->nik_atasan1);
                } elseif (trim($item->statuspen) == 'N') {
                      $employee_id = !empty(trim($item->nik_atasan2)) ? trim($item->nik_atasan2) : null;
                } else {
                     $employee_id = trim($item->nik_appr);
                }

                $this->M_Secret->q_transaction_create(array(
                'employee_id' => $employee_id,
                'secret_id' => $item->identifier,
                'url' => $refurl,
                'input_by' => (!empty($item->nik) ? $item->nik : 'SYSTEM'),
                'input_date' => date('Y-m-d H:i:s'),
            ));
          
        }
            // var_dump($messages, $employee_id, $item);
            // die();
            
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($messages),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                        'Content-Type: application/json'
                    ),
                )
            );
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->db->insert(
                            'sc_log.success_notifications',
                            array(
                                'modul' => 'notification',
                                'message' => json_encode($body),
                                'properties' => json_encode($info),
                                'input_by' => 'SYSTEM',
                                'input_date' => date('Y-m-d H:i:s'),
                            )
                        );
                    }
                    return true;
                } else {
                    $this->db->insert(
                        'sc_log.error_notifications',
                        array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        )
                    );
                }
            }
            header('Content-Type: application/json');
            return true;
        } else {
            return false;
        }
    }

        public function msgojt($status = '')
    {
        $this->load->model(array('secret/M_Secret','Api/M_Ojt'));
        //$status = 'P';
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));
        $messages = array();
      
            // var_dump($messages);
            // die();

        foreach ($this->M_Ojt->q_whatsapp_collect_where()->result() as $item) {
            $ref = $this->shuffle();
             $message = '' .
                        '<table width="600px" background="' . $this->bg . '" border="1" cellpadding="5" cellspacing="0">
                            <thead>
                                <tr>
                                    <th colspan="3"><b>LIST KARYAWAN OJT YANG AKAN BERAKHIR</b></th>
                                </tr>
                                <tr>
                                    <th width="40%">Nama</th>
                                    <th width="30%">Tanggal OJT</th>
                                    <th width="30%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>';

                    foreach ($this->M_Ojt->q_ojt()->result() as $ojt) {
                        $message .= '
                            <tr>
                                <td>' . htmlspecialchars(trim($ojt->nmlengkap)) . '</td>
                                <td text-center>' . htmlspecialchars(trim($ojt->tgl_ojt)) . '</td>
                                <td>' . htmlspecialchars(trim($ojt->eventketerangan)) . '</td>
                            </tr>';
                    }

                    $message .= '
                            </tbody>
                        </table>';

                $output = 'assets/img/notifojt/' . date('d-m-Y') . '_' . $ref . '.jpg';
                $fullpath = (ENVIRONMENT == 'development' ? 'https://dummyimage.com/300/09f/fff.png' : base_url($output));
                //$fullpath = base_url($output);
                $this->imageCreatorojt($message, $output);

            // var_dump($item);
            // exit;
            
            array_push(
                $messages,
                array(
                    'message' => json_encode(
                        array(
                            'path' => str_replace('\\', '/', $fullpath),
                            'caption' => 'Yth HRGA' . PHP_EOL . PHP_EOL . '*Harap Segera menindaklanjuti list karyawan OJT diatas sebelum waktu OJT berakhir*' . PHP_EOL . PHP_EOL 
                            . 'Terima Kasih' . PHP_EOL
                            . 'Ref:' . $ref . '_' 
                        )
                    ),
                    'message_type' => 'imageMessage',
                    'is_interactive' => false,
                    'outbox_for' => trim($item->nohp1),
                    'retry' => 1,
                    'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                    'properties' => array(
                        'reference' => $ref,
                        'employeeid' =>  $item->nik,
                        //'range' => $after,
                    ),
                )
            );
          
        }
            // var_dump($messages, $employee_id, $item);
            // die();
            
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($messages),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                        'Content-Type: application/json'
                    ),
                )
            );
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->db->insert(
                            'sc_log.success_notifications',
                            array(
                                'modul' => 'notification',
                                'message' => json_encode($body),
                                'properties' => json_encode($info),
                                'input_by' => 'SYSTEM',
                                'input_date' => date('Y-m-d H:i:s'),
                            )
                        );
                    }
                    return true;
                } else {
                    $this->db->insert(
                        'sc_log.error_notifications',
                        array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        )
                    );
                }
            }
            header('Content-Type: application/json');
            return true;
        } else {
            return false;
        }
    }

        public function msgba($status = '')
    {
        $this->load->model(array('secret/M_Secret','Api/M_BeritaAcara'));
        $status = "('A1','A2','B')";
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));
        $messages = array();
      
            // var_dump($messages);
            // die();

        foreach ($this->M_BeritaAcara->q_whatsapp_collect_where(" and status in $status ")->result() as $item) {
             $urlsetup = $this->db->query("select value1 from sc_mst.option where trim(kdoption) = 'URL-MSGPK'")->row()->value1;
             $refurl = $urlsetup . 'trans/sberitaacara';
             $url = $urlsetup . $item->identifier;
            $ref = $this->shuffle();
            $message = '' .
                '<table width=\'400\' background=\'' . $this->bg . '\'>
                    <thead>
                      <tr>
                        <th colspan=\'3\'><b>PERSETUJUAN BERITA ACARA</b></th>
                      </tr>
                      <tr><th colspan=\'3\'>&nbsp;</th></tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Nama Karyawan</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . trim($item->nmlengkap) . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>NIK</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . trim($item->nik) . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Bagian</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . trim($item->nmdept) . '</b></td>
                      </tr>
                     <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Jabatan</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . trim($item->nmjabatan) . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Subjek</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . trim($item->subjek) . '</b></td>
                      </tr>
                        <tr>
                          <td valign=\'top\' style=\'width: 30%;\'>Jenis Laporan</td>
                          <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                          <td valign=\'top\' style=\'width: 65%;\'><b>' . trim($item->nmlaporan) . '</b></td>
                        </tr>
                      <tr>
                        <tr>
                          <td valign=\'top\' style=\'width: 30%;\'>Uraian</td>
                          <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                          <td valign=\'top\' style=\'width: 65%;\'><b>' . strtoupper(trim($item->uraian)) . '</b></td>
                        </tr>
                             <tr>
                          <td valign=\'top\' style=\'width: 30%;\'>Lokasi kejadian</td>
                          <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                          <td valign=\'top\' style=\'width: 65%;\'><b>' . strtoupper(trim($item->lokasi)) . '</b></td>
                        </tr>
                            <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Waktu</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . trim($item->docdate) . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\' style=\'width: 30%;\'>Status</td>
                        <td valign=\'top\' style=\'width: 5%; text-align: left;\'>:</td>
                        <td valign=\'top\' style=\'width: 65%;\'><b>' . trim($item->nmstatus) . '</b></td>
                      </tr>
                      <tr>
                        <td valign=\'top\'>&nbsp;</td>
                      </tr>
                      <tr>
                        <td valign=\'top\'>&nbsp;</td>
                      </tr>
                    </tbody>
                </table>'
                . '';
            $item->docno = str_replace(['/',' '], ['-',''], trim($item->docno));
            $output = 'assets/img/notifba/' . $item->docno . '_' . $ref . '.jpg';
            $fullpath = (ENVIRONMENT == 'development' ? 'https://dummyimage.com/300/09f/fff.png' : base_url($output));
            //$fullpath = base_url($output);
            $this->imageCreator($message, $output);

             if (trim($item->status) == 'A1') {
                $appr = trim($item->nmatasan1);
            } elseif (trim($item->status) == 'A2') {
                $appr = trim($item->nmatasan2);
            } else {
                $appr = trim($item->nmhrd);
                
            }

            // var_dump($fullpath);
            // exit;
            
            array_push(
                $messages,
                array(
                    'message' => json_encode(
                        array(
                            'path' => str_replace('\\', '/', $fullpath),
                            'caption' => 'Yth ' . $appr . PHP_EOL . PHP_EOL . '*Harap Segera menindaklanjuti dokumen Berita Acara yang tertera diatas*' . PHP_EOL . PHP_EOL .$url. PHP_EOL . PHP_EOL
                            . 'Jika ada pertanyaan silahkan hubungi bagian HRGA' . PHP_EOL . PHP_EOL
                            . 'Terima Kasih' . PHP_EOL
                            . 'Ref:' . $ref . '_' 
                        )
                    ),
                    'message_type' => 'imageMessage',
                    'is_interactive' => false,
                    'outbox_for' => trim( $item->approver),
                    'retry' => 1,
                    'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                    'properties' => array(
                        'reference' => $ref,
                        'employeeid' =>  $item->nik,
                        //'range' => $after,
                    ),
                )
            );

                 if (trim($item->status) == 'A1') {
                     $employee_id = trim($item->nikatasan1);
                } elseif (trim($item->status) == 'A2') {
                     $employee_id = trim($item->nikatasan2);
                } else {
                     $employee_id = trim($item->nikhrd);
                }

                $this->M_Secret->q_transaction_create(array(
                'employee_id' => $employee_id,
                'secret_id' => $item->identifier,
                'url' => $refurl,
                'input_by' => (!empty($item->nik) ? $item->nik : 'SYSTEM'),
                'input_date' => date('Y-m-d H:i:s'),
            ));
          
        }
          
            
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($messages),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                        'Content-Type: application/json'
                    ),
                )
            );
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->db->insert(
                            'sc_log.success_notifications',
                            array(
                                'modul' => 'notification',
                                'message' => json_encode($body),
                                'properties' => json_encode($info),
                                'input_by' => 'SYSTEM',
                                'input_date' => date('Y-m-d H:i:s'),
                            )
                        );
                    }
                    return true;
                } else {
                    $this->db->insert(
                        'sc_log.error_notifications',
                        array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        )
                    );
                }
            }
            header('Content-Type: application/json');
            return true;
        } else {
            return false;
        }
    }


    public function sendapprovalcuti()
    {
        if ($this->msgcuti()) {
        } else {
            if ($this->refresh()) {
                $this->msgcuti();
            } else {
                if ($this->auth()) {
                    $this->msgcuti();
                }
            }
        }
    }

     public function sendnotificationpk()
    {
        if ($this->msgpk()) {
        } else {
            if ($this->refresh()) {
                $this->msgpk();
            } else {
                if ($this->auth()) {
                    $this->msgpk();
                }
            }
        }
    }

    public function sendnotificationojt()
    {
        if ($this->msgojt()) {
        } else {
            if ($this->refresh()) {
                $this->msgojt();
            } else {
                if ($this->auth()) {
                    $this->msgpk();
                }
            }
        }
    }

         public function sendnotificationba()
    {
        if ($this->msgba()) {
        } else {
            if ($this->refresh()) {
                $this->msgba();
            } else {
                if ($this->auth()) {
                    $this->msgba();
                }
            }
        }
    }

    public function sendapprovalijindt()
    {
        if ($this->msgijindt()) {
        } else {
            if ($this->refresh()) {
                $this->msgijindt();
            } else {
                if ($this->auth()) {
                    $this->msgijindt();
                }
            }
        }
    }

    public function sendapprovalijinik()
    {
        if ($this->msgijinik()) {
        } else {
            if ($this->refresh()) {
                $this->msgijinik();
            } else {
                if ($this->auth()) {
                    $this->msgijinik();
                }
            }
        }
    }
	
	public function sendapprovalijinskd()
    {
        if ($this->msgskd()) {
        } else {
            if ($this->refresh()) {
                $this->msgskd();
            } else {
                if ($this->auth()) {
                    $this->msgskd();
                }
            }
        }
    }

    public function sendapprovalijinpa()
    {
        if ($this->msgijinpa()) {
        } else {
            if ($this->refresh()) {
                $this->msgijinpa();
            } else {
                if ($this->auth()) {
                    $this->msgijinpa();
                }
            }
        }
    }

    public function sendapprovallembur()
    {
        if ($this->msglembur()) {
        } else {
            if ($this->refresh()) {
                $this->msglembur();
            } else {
                if ($this->auth()) {
                    $this->msglembur();
                }
            }
        }
    }

    public function sendapprovaldinas()
    {
        if ($this->msgdinas()) {
        } else {
            if ($this->refresh()) {
                $this->msgdinas();
            } else {
                if ($this->auth()) {
                    $this->msgdinas();
                }
            }
        }
    }

    public function sendapprovalsppb()
    {
        if ($this->msgsppb()) {
        } else {
            if ($this->refresh()) {
                $this->msgsppb();
            } else {
                if ($this->auth()) {
                    $this->msgsppb();
                }
            }
        }
    }

    public function resendapprovalcuti()
    {
        if ($this->msgcuti('true')) {
        } else {
            if ($this->refresh()) {
                $this->msgcuti('true');
            } else {
                if ($this->auth()) {
                    $this->msgcuti('true');
                }
            }
        }
    }

    public function resendapprovalijindt()
    {
        if ($this->msgijindt('true')) {
        } else {
            if ($this->refresh()) {
                $this->msgijindt('true');
            } else {
                if ($this->auth()) {
                    $this->msgijindt('true');
                }
            }
        }
    }

    public function resendapprovalijinik()
    {
        if ($this->msgijinik('true')) {
        } else {
            if ($this->refresh()) {
                $this->msgijinik('true');
            } else {
                if ($this->auth()) {
                    $this->msgijinik('true');
                }
            }
        }
    }
	
	public function resendapprovalijinskd()
    {
        if ($this->msgskd('true')) {
        } else {
            if ($this->refresh()) {
                $this->msgskd('true');
            } else {
                if ($this->auth()) {
                    $this->msgskd('true');
                }
            }
        }
    }

    public function resendapprovalijinpa()
    {
        if ($this->msgijinpa('true')) {
        } else {
            if ($this->refresh()) {
                $this->msgijinpa('true');
            } else {
                if ($this->auth()) {
                    $this->msgijinpa('true');
                }
            }
        }
    }

    public function resendapprovallembur()
    {
        if ($this->msglembur('true')) {
        } else {
            if ($this->refresh()) {
                $this->msglembur('true');
            } else {
                if ($this->auth()) {
                    $this->msglembur('true');
                }
            }
        }
    }

    public function resendapprovaldinas()
    {
        if ($this->msgdinas('true')) {
        } else {
            if ($this->refresh()) {
                $this->msgdinas('true');
            } else {
                if ($this->auth()) {
                    $this->msgdinas('true');
                }
            }
        }
    }

    public function cancelationNotificationMessage($type)
    {
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));

        $messages = [];
        if ($type == 'CUTI') {
            foreach ($this->m_cuti->q_whatsapp_collect_where('
            AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
            AND ck.status = \'C\' AND cancel_date::date = now()::date AND whatsappreject = FALSE
            ORDER BY input_date desc
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {

                array_push(
                    $messages,
                    array(
                        'message' => json_encode(
                            array(
                                'message' => "Pengajuan *CUTI* dengan nomor dokumen *$item->nodok*, atas nama *$item->nama*. Pada tanggal: $item->tgl_mulai - $item->tgl_selesai. Telah *Dibatalkan* otomatis oleh SYSTEM",
                            )
                        ),
                        'message_type' => 'conversation',
                        'outbox_for' => $item->userjid,
                        'retry' => 1,
                        'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                        'properties' => array(
                            'objectid' => $item->nodok,
                        ),
                    )
                );
            }
        } elseif ($type == 'IJIN') {
            foreach ($this->m_ijin->q_whatsapp_collect_where('
            AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
            AND ck.status = \'C\' AND cancel_date::date = now()::date AND whatsappreject = FALSE
            ORDER BY input_date desc
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {

                array_push(
                    $messages,
                    array(
                        'message' => json_encode(
                            array(
                                'message' => "Pengajuan *$item->jenis_ijin $item->tipe_ijin* dengan nomor dokumen *$item->nodok*, atas nama *$item->nama*. Pada tanggal: $item->tgl_kerja. Telah *Dibatalkan* otomatis oleh SYSTEM",
                            )
                        ),
                        'message_type' => 'conversation',
                        'outbox_for' => $item->userjid,
                        'retry' => 1,
                        'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                        'properties' => array(
                            'objectid' => $item->nodok,
                        ),
                    )
                );
            }
        } elseif ($type == 'DINAS') {
            foreach ($this->m_dinas->q_whatsapp_collect_where('
            AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
            AND ck.status = \'C\' AND cancel_date::date = now()::date AND whatsappreject = FALSE
            ORDER BY input_date desc
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {

                array_push(
                    $messages,
                    array(
                        'message' => json_encode(
                            array(
                                'message' => "Pengajuan *DINAS* dengan nomor dokumen *$item->nodok*, atas nama *$item->nama*. Pada tanggal: $item->tgl_mulai - $item->tgl_selesai. Telah *Dibatalkan* otomatis oleh SYSTEM",
                            )
                        ),
                        'message_type' => 'conversation',
                        'outbox_for' => $item->userjid,
                        'retry' => 1,
                        'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                        'properties' => array(
                            'objectid' => $item->nodok,
                        ),
                    )
                );
            }
        } elseif ($type == 'LEMBUR') {
            foreach ($this->m_lembur->q_whatsapp_collect_where('
            AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
            AND ck.status = \'C\' AND cancel_date::date = now()::date AND whatsappreject = FALSE
            ORDER BY input_date desc
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {

                array_push(
                    $messages,
                    array(
                        'message' => json_encode(
                            array(
                                'message' => "Pengajuan *LEMBUR* dengan nomor dokumen *$item->nodok*, atas nama *$item->nama*. Pada tanggal: $item->tgl_kerja. Telah *Dibatalkan* otomatis oleh SYSTEM",
                            )
                        ),
                        'message_type' => 'conversation',
                        'outbox_for' => $item->userjid,
                        'retry' => 1,
                        'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                        'properties' => array(
                            'objectid' => $item->nodok,
                        ),
                    )
                );
            }
        }
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($messages),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                        'Content-Type: application/json'
                    ),
                )
            );
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        if ($type == 'CUTI'){
                            $this->m_cuti->q_trx_update(
                                array(
                                    'whatsappreject' => TRUE,
                                ),
                                array('TRIM(nodok)' => $row->properties->objectid)
                            );
                        } elseif ($type == 'IJIN'){
                            $this->m_ijin->q_trx_update(
                                array(
                                    'whatsappreject' => TRUE,
                                ),
                                array('TRIM(nodok)' => $row->properties->objectid)
                            );
                        } elseif ($type == 'DINAS'){
                            $this->m_dinas->q_trx_update(
                                array(
                                    'whatsappreject' => TRUE,
                                ),
                                array('TRIM(nodok)' => $row->properties->objectid)
                            );
                        } elseif ($type == 'LEMBUR'){
                            $this->m_lembur->q_trx_update(
                                array(
                                    'whatsappreject' => TRUE,
                                ),
                                array('TRIM(nodok)' => $row->properties->objectid)
                            );
                        }                        
                        $this->db->insert(
                            'sc_log.success_notifications',
                            array(
                                'modul' => 'notification',
                                'message' => json_encode($body),
                                'properties' => json_encode($info),
                                'input_by' => 'SYSTEM',
                                'input_date' => date('Y-m-d H:i:s'),
                            )
                        );
                    }
                    header('Content-Type: application/json');
                    echo json_encode(
                        array(
                            'return' => false,
                            'info' => $info,
                            'body' => $body,
                        ),
                        JSON_PRETTY_PRINT
                    );
                    return true;
                } else {
                    $this->db->insert(
                        'sc_log.error_notifications',
                        array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        )
                    );
                }
            }
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => false,
                    'info' => $info,
                    'body' => $body,
                ),
                JSON_PRETTY_PRINT
            );
            return false;
        } else {
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => true,
                    'info' => array(),
                    'body' => array(),
                    'message' => 'Empty data will skip post to whatsapp bot',
                ),
                JSON_PRETTY_PRINT
            );
            return true;
        }
    }

    public function sendCancelationNotification($type)
    {
        if ($this->cancelationNotificationMessage($type)) {
        } else {
            if ($this->refresh()) {
                $this->cancelationNotificationMessage($type);
            } else {
                if ($this->auth()) {
                    $this->cancelationNotificationMessage($type);
                }
            }
        }
    }

      public function responseMessage($documentInfo = array(), $outboxfor)
    {
        $this->load->model(array('master/m_option'));
        $this->load->model('M_Setup');
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));
        $ref = $this->shuffle();
        $messages = [];
        $documentid = $documentInfo['documentid'];
        $documentMessage = $documentInfo['message'];
        $outbox_for = $outboxfor;
        array_push($messages,
            array(
                'message' => json_encode(
                    array(
                        'message' => $documentMessage. PHP_EOL . PHP_EOL
                            . '_Ref:' . $ref . '_',
                    )
                ),
                'message_type' => 'conversation',
                'outbox_for' => $outbox_for,
                'is_interactive' => false,
                'retry' => 0,
                'session' => $this->M_Setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                'properties' => array(
                    'objectid' => "$documentid",
                    'reference' => "$ref",
                    'branch' => "$branch",
                ),
            )
        );
       //var_dump($messages);die();
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $this->M_Setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($messages),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $this->M_Setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                        'Content-Type: application/json'
                    ),
                )
            );
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->db->insert(
                            'sc_log.success_notifications',
                            array(
                                'modul' => 'notification',
                                'message' => json_encode($body),
                                'properties' => json_encode($info),
                                'input_by' => 'SYSTEM',
                                'input_date' => date('Y-m-d H:i:s'),
                            )
                        );
                    }
                    header('Content-Type: application/json');
                    echo json_encode(
                        array(
                            'return' => false,
                            'info' => $info,
                            'body' => $body,
                        ),
                        JSON_PRETTY_PRINT
                    );
                    return true;
                } else {
                    $this->db->insert(
                        'sc_log.error_notifications',
                        array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        )
                    );
                }
            }
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => false,
                    'info' => $info,
                    'body' => $body,
                ),
                JSON_PRETTY_PRINT
            );
            return false;
        } else {
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'return' => true,
                    'info' => array(),
                    'body' => array(),
                    'message' => 'Empty data will skip post to whatsapp bot',
                ),
                JSON_PRETTY_PRINT
            );
            return true;
        }
    }

    public function sendResponseMessage($documentInfo, $outboxfor)
    {
        //var_dump($documentInfo, $outboxfor);die();
        if ($this->responseMessage($documentInfo, $outboxfor)) {
            // Message sent successfully, do something if needed
        } else {
            if ($this->refresh()) {
                $this->responseMessage($documentInfo, $outboxfor);
            } else {
                if ($this->auth()) {
                    $this->responseMessage($documentInfo, $outboxfor);
                }
            }
        }
    }
}
