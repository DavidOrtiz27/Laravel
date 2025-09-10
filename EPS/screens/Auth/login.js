import {
  StyleSheet,
  Text,
  Image,
  TouchableOpacity,
  Alert,
  ScrollView,
  View,
} from "react-native";
import TextInputComponent from "../../components/inputComponent";
import { useNavigation } from "@react-navigation/native";

export default function Login() {
  const navigation = useNavigation();

  return (
    <ScrollView
      contentContainerStyle={styles.container}
      keyboardShouldPersistTaps="handled"
    >
      <Image source={require("../../assets/mapu.png")} style={styles.logo} />

      {/* Título principal */}
      <Text style={styles.title}>Sistema de Gestión Médica</Text>

      {/* Subtítulo */}
      <Text style={styles.subtitle}>Iniciar Sesión</Text>

    <View style={styles.form}>
      {TextInputComponent(
        "Email",
        "Ingrese su email",
        "email-address"
      )}
      {TextInputComponent(
        "Contraseña",
        "Ingrese su contraseña"
      )}
      </View>

      <Text style={styles.textLink}>Recuperar Contraseña</Text>

      <TouchableOpacity
        style={styles.button}
        onPress={() => Alert.alert("Iniciar Sesión", "Botón presionado")}
      >
        <Text style={styles.buttonText}>Iniciar Sesión</Text>
      </TouchableOpacity>

      <Text
        style={styles.textCreate}
        onPress={() => navigation.navigate("Register")}
      >
        ¿Aún no tienes cuenta?
      </Text>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: {
    flexGrow: 1,
    backgroundColor: "#DDE6ED",
    alignItems: "center",
    justifyContent: "center",
    paddingHorizontal: 30,
  },
  header: {
    alignItems: "center",
    marginTop: -70,
  },
  logo: {
    width: 180,
    height: 180,
    marginBottom: 10,
    resizeMode: "contain",
  },
  title: {
    fontSize: 34, 
    fontWeight: "700",
    marginBottom: 12,
    textAlign: "center",
    color: "#000",
    top: -40,
  },
  subtitle: {
    fontSize: 22,
    fontWeight: "500",
    marginBottom: 28,
    textAlign: "center",
    color: "#333",
  },
  form: {
    top: -20,
    width: "100%",
    maxWidth: 350,
    marginBottom: 20,
  },
  textLink: {
    color: "#007BFF",
    fontSize: 16,
    marginTop: 12,
    textAlign: "right",
    alignSelf: "stretch",
    marginRight: 4,
  },
  textCreate: {
    color: "#007BFF",
    fontSize: 16,
    marginTop: 60,
    textAlign: "center",
    padding: 20,
  },
  button: {
    backgroundColor: "#007BFF",
    paddingVertical: 14,
    paddingHorizontal: 40,
    borderRadius: 8,
    marginTop: 24,
    width: "100%",
    alignItems: "center",
    maxWidth: 350,
  },
  buttonText: {
    color: "#fff",
    fontSize: 18,
    fontWeight: "bold",
  },
});
